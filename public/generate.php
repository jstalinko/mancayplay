<?php
// Filename: index.php
// To run:
// 1. Place this file in your web server's directory (e.g., htdocs, www).
// OR
// 2. Run from the command line: php -S 127.0.0.1:5000

// --- Configuration ---
define("LOG_FILE", "generator.log");
// IMPORTANT: Update this path to your executable file
define("EXECUTABLE_PATH", "C:\\Users\\amd ryzen v\\OneDrive\\Documents\\Project Website\\CALCIO 12");

// --- CORS and Headers ---
// Allow requests from any origin
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Handle pre-flight OPTIONS request for CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}

/**
 * Logs a message to a file and prints it.
 * @param string $prefix The prefix for the log entry (e.g., "INPUT", "GEN").
 * @param string $message The message to log.
 */
function log_to_file($prefix, $message) {
    $timestamp = date("Y-m-d H:i:s");
    $log_line = "[{$timestamp}] {$prefix} >> {$message}\n";
    
    // Append to log file
    file_put_contents(LOG_FILE, $log_line, FILE_APPEND);
    
    // For debugging: output to PHP's error log
    error_log($log_line);
}

/**
 * Sends a JSON response and terminates the script.
 * @param int $statusCode HTTP status code.
 * @param array $data The data to encode as JSON.
 */
function send_json_response($statusCode, $data) {
    http_response_code($statusCode);
    echo json_encode($data);
    exit;
}

// --- Main Logic ---

// Clear log file on first script execution (if it's a new server start)
// Note: This is a simple approach. In a real-world scenario, you might handle this differently.
if (!file_exists(LOG_FILE) || filemtime(LOG_FILE) < time() - 5) {
    file_put_contents(LOG_FILE, "=== Generator Log Start ===\n");
}

// Simple routing based on the request URI
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($request_uri === '/ping') {
    send_json_response(200, ["status" => "ok"]);
} elseif ($request_uri === '/generate' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $json_data = file_get_contents("php://input");
    $data = json_decode($json_data, true);

    if (empty($data) || !isset($data['ticket'])) {
        send_json_response(400, ["error" => "Tidak ada ticket dikirim"]);
    }

    $raw_ticket = trim($data['ticket']);

    // The original Python script had a commented-out section to add a header.
    // This logic is preserved but commented out. Uncomment if needed.
    // if (strpos($raw_ticket, "exe:") !== 0) {
    //     $raw_ticket = "exe:" . $raw_ticket;
    // }

    $token_final = null;

    // Descriptors for the process pipes (stdin, stdout, stderr)
    $descriptorspec = [
       0 => ["pipe", "r"],  // stdin is a pipe that we can write to
       1 => ["pipe", "w"],  // stdout is a pipe that we can read from
       2 => ["pipe", "w"]   // stderr is a pipe to read from
    ];

    // The `proc_open` function is the PHP equivalent of subprocess.Popen
    $process = proc_open(EXECUTABLE_PATH, $descriptorspec, $pipes);

    if (is_resource($process)) {
        // Write '1' to select the menu option
        fwrite($pipes[0], "1\n");
        log_to_file("INPUT", "1");

        // Write the ticket
        fwrite($pipes[0], $raw_ticket . "\n");
        log_to_file("INPUT", $raw_ticket);
        
        // Close stdin as we are done writing
        fclose($pipes[0]);

        // Read the entire output from stdout
        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);
        
        // Read any errors
        $errors = stream_get_contents($pipes[2]);
        fclose($pipes[2]);
        
        // Close the process
        $return_value = proc_close($process);
        log_to_file("SYSTEM", "Process exited with code {$return_value}");
        if(!empty($errors)) {
            log_to_file("GEN_ERR", $errors);
        }

        // Process the output
        $lines = explode("\n", $output);
        foreach ($lines as $line) {
            $line = trim($line);
            if (!empty($line)) {
                log_to_file("GEN", $line);
                // Use preg_match to find the token
                if (preg_match('/\((.+?)\)/', $line, $matches)) {
                    $token_final = $matches[1];
                }
            }
        }

        if (!$token_final) {
            send_json_response(500, ["error" => "Token tidak ditemukan"]);
        }

        send_json_response(200, ["token" => $token_final]);

    } else {
        send_json_response(500, ["error" => "Failed to start generator process"]);
    }

} else {
    send_json_response(404, ["error" => "Endpoint not found"]);
}

?>
