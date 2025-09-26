<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; // 1. Tambahkan use statement untuk File facade
use Illuminate\Support\Facades\Validator;

class TokenGeneratorController extends Controller
{

    private $EXECUTABLE_PATH;

    public function __construct()
    {
        // 2. Ganti blok hardcoded dengan pemindaian dinamis
        $executablePaths = [];
        $generatorTypes = ['fc2025', 'fc2026']; // Tipe generator yang akan dicari

        foreach ($generatorTypes as $type) {
            $basePath = public_path('generator/account_' . $type);
            $executablePaths[$type] = [];

            // Pastikan direktori utama ada sebelum mencoba memindai
            if (File::isDirectory($basePath)) {
                // Dapatkan semua file dari direktori dan sub-direktorinya
                $allFiles = File::allFiles($basePath);

                foreach ($allFiles as $file) {
                    // Jika nama file adalah 'token_generator.exe', tambahkan path lengkapnya
                    if ($file->getFilename() === 'token_generator.exe') {
                        $executablePaths[$type][] = $file->getRealPath();
                    }
                }
            }
        }

        $this->EXECUTABLE_PATH = $executablePaths;
    }

    public function index(Request $request)
    {
        if (!auth()->user()->license_fc25 && $request->type == 'fc2025') {
            return redirect('/dashboard');
        }
        if (!auth()->user()->license_fc26 && $request->type == 'fc2026') {
            return redirect('/dashboard');
        }
        $data['user_id'] = Auth::user()->id;
        $data['type'] = $request->type;
        return Inertia::render('token-generator', $data);
    }

    /**
     * A simple endpoint to check if the API is running.
     * Corresponds to the original /ping route.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ping(): JsonResponse
    {
        return response()->json(['status' => 'ok']);
    }
      public function generate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ticket' => 'required|string|min:1',
            'type' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Pastikan input sudah benar.', 'details' => $validator->errors()], 400);
        }

        $type = $request->input('type');

        if (empty($this->EXECUTABLE_PATH[$type])) {
            Log::error("Tidak ada generator yang ditemukan untuk tipe: {$type}.");
            return response()->json(['success' => false, 'message' => 'Kesalahan konfigurasi generator.'], 500);
        }

        $rawTicket = $request->input('ticket');
        $tokenFinal = null;
        $process = null; // Inisialisasi variabel proses

        // Gunakan try...finally untuk memastikan proses selalu ditutup
        try {
            $descriptorSpec = [
                0 => ["pipe", "r"], // stdin
                1 => ["pipe", "w"], // stdout
                2 => ["pipe", "w"]  // stderr
            ];

            shuffle($this->EXECUTABLE_PATH[$type]);
            $executablePath = $this->EXECUTABLE_PATH[$type][0];
            Log::info("Memulai generator: " . $executablePath);

            // Membuka proses
            $process = proc_open("wine " . escapeshellarg($executablePath), $descriptorSpec, $pipes);

            if (!is_resource($process)) {
                Log::critical("Gagal memulai proses generator.");
                return response()->json(['success' => false, 'message' => 'Gagal memulai proses generator.'], 500);
            }

            // --- PERUBAHAN UTAMA: PROSES INTERAKTIF & CEPAT ---

            // 1. Tulis input ke generator
            fwrite($pipes[0], "1\n");
            fwrite($pipes[0], $rawTicket . "\n");
            fclose($pipes[0]); // Tutup stdin setelah selesai menulis

            // 2. Baca output secara REAL-TIME, baris per baris (BUKAN menunggu semua)
            $fullOutput = '';
            while (($line = fgets($pipes[1])) !== false) {
                $trimmedLine = trim($line);
                $fullOutput .= $line; // Kumpulkan semua output untuk logging jika perlu
                Log::info("[GEN] >> " . $trimmedLine);

                // 3. Cek token di setiap baris
                if (preg_match('/Generated token:\s*(.+)/', $trimmedLine, $matches)) {
                    $tokenFinal = trim($matches[1]);
                    Log::info("Token DITEMUKAN: " . $tokenFinal);
                    
                    // 4. SEGERA HENTIKAN PROSES! Tidak perlu menunggu selesai.
                    proc_terminate($process); 
                    break; // Keluar dari loop while
                }
            }
            
            // Simpan log jika Anda masih memerlukannya untuk debug
            // Perbaikan path: gunakan dirname() untuk mendapatkan direktori
            file_put_contents(dirname($executablePath) . "/result_log.txt", $fullOutput . PHP_EOL, FILE_APPEND);
            
            // Baca error stream
            $errors = stream_get_contents($pipes[2]);
            if (!empty($errors)) {
                Log::error("[GEN_ERR] >> " . $errors);
            }

        } finally {
            // 5. Pastikan semua resource ditutup dengan aman
            if (isset($pipes) && is_array($pipes)) {
                if (is_resource($pipes[1])) fclose($pipes[1]);
                if (is_resource($pipes[2])) fclose($pipes[2]);
            }
            if (is_resource($process)) {
                proc_close($process);
            }
        }

        if (!$tokenFinal) {
            Log::error("[GEN_ERR] >> Token tidak dapat diekstrak dari output.");
            return response()->json(['success' => false, 'message' => 'Token tidak ditemukan dalam output generator.'], 500);
        }

        // Proses update kuota user
        $user = \App\Models\User::find($request->user_id);
        if ($type == 'fc2025') {
            $user->decrement('generate_token_quota');
        } elseif ($type == 'fc2026') {
            $user->decrement('generate_token_quota_fc26');
        }

        return response()->json(['success' => true, 'data' => ['token' => $tokenFinal]]);
    }
}
