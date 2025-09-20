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

    /**
     * Receives a ticket, runs the external generator, and returns a token.
     * Corresponds to the original /generate route.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function generate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'ticket' => 'required|string|min:1',
            'type' => 'required|string',
            'user_id' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Pastikan input sudah benar'], 400);
        }

        $rawTicket = trim($request->input('ticket'));
        $type = trim($request->input('type'));
        $tokenFinal = null;

        // 3. (Opsional tapi direkomendasikan) Tambahkan pengecekan jika tidak ada generator yang ditemukan
        if (empty($this->EXECUTABLE_PATH[$type])) {
            Log::error("Tidak ada generator yang ditemukan untuk tipe: {$type}. Periksa struktur direktori.");
            return response()->json(['success' => false, 'message' => 'Kesalahan konfigurasi generator, coba lagi nanti..'], 500);
        }

        $descriptorSpec = [
           0 => ["pipe", "r"],
           1 => ["pipe", "w"],
           2 => ["pipe", "w"]
        ];

        shuffle($this->EXECUTABLE_PATH[$type]);
        shuffle($this->EXECUTABLE_PATH[$type]);

        $executablePath = $this->EXECUTABLE_PATH[$type][0];
        Log::info("Path : " . $executablePath);

        $process = proc_open("wine " . escapeshellarg($executablePath), $descriptorSpec, $pipes); // Gunakan escapeshellarg untuk keamanan

        if (is_resource($process)) {
            fwrite($pipes[0], "1\n");
            Log::info('[INPUT] >> 1');

            fwrite($pipes[0], $rawTicket . "\n");
            Log::info("[INPUT] >> " . $rawTicket);
            
            fclose($pipes[0]);

            $output = stream_get_contents($pipes[1]);
            fclose($pipes[1]);
            
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[2]);
            
            $returnValue = proc_close($process);
            Log::info("[SYSTEM] >> Process exited with code {$returnValue}");
            
            if (!empty($errors)) {
                Log::error("[GEN_ERR] >> " . $errors);
            }

            $lines = explode("\n", $output);
            foreach ($lines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    Log::info("[GEN] >> " . $line);
                    if (preg_match('/\((.+?)\)/', $line, $matches)) {
                        $tokenFinal = $matches[1];
                    }
                }
            }

            if (!$tokenFinal) {
                return response()->json(['success' => false, 'message' => 'Token tidak ditemukan, coba lagi nanti..'], 500);
            }
            $user_id = $request->user_id;
            $user = \App\Models\User::find($user_id);
            if($type == 'fc2025')
            {
                $quota = ($user->generate_token_quota-1);
                $user->generate_token_quota = $quota;
                $user->save();
            }elseif($type == 'fc2026')
            {
                $quota = ($user->generate_token_quota_fc26-1);
                $user->generate_token_quota_fc26 = $quota;
                $user->save();
            }

            return response()->json(['success' => true, 'data' => ['token' => $tokenFinal, 'generate_token_quota' => 2]]);

        } else {
            Log::critical("[FATAL] >> Failed to start generator process.");
            return response()->json(['success' => false, 'message' => 'Failed to start generator process, coba lagi nanti..'], 500);
        }
    }
}