<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TokenGeneratorController extends Controller
{

    private $EXECUTABLE_PATH;

    // ... (Fungsi __construct dan index tetap sama, tidak perlu diubah) ...
    public function __construct()
    {
        $executablePaths = [];
        $generatorTypes = ['fc2025', 'fc2026'];

        foreach ($generatorTypes as $type) {
            $basePath = public_path('generator/account_' . $type);
            $executablePaths[$type] = [];

            if (File::isDirectory($basePath)) {
                $allFiles = File::allFiles($basePath);
                foreach ($allFiles as $file) {
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
    
    // --- FUNGSI GENERATE YANG BARU, LEBIH SIMPEL DAN STABIL ---
    public function generate(Request $request): JsonResponse
    {
        // Set batas waktu eksekusi PHP untuk skrip ini saja
        set_time_limit(120); // 2 menit, untuk jaga-jaga

        $validator = Validator::make($request->all(), [
            'ticket' => 'required|string|min:1',
            'type' => 'required|string|in:fc2025,fc2026',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Input tidak valid.'], 400);
        }

        $type = $request->input('type');
        $rawTicket = trim($request->input('ticket'));
        $tokenFinal = null;

        if (empty($this->EXECUTABLE_PATH[$type])) {
            Log::error("Tidak ada generator yang ditemukan untuk tipe: {$type}.");
            return response()->json(['success' => false, 'message' => 'Kesalahan konfigurasi generator.'], 500);
        }

        shuffle($this->EXECUTABLE_PATH[$type]);
        $executablePath = $this->EXECUTABLE_PATH[$type][0];

        // 1. Siapkan input dan perintah shell
        // Perintah ini meniru: mengetik "1", tekan enter, ketik ticket, tekan enter.
        $inputString = "1\n" . $rawTicket;

        // PENTING: Gunakan path absolut ke wine untuk menghindari masalah environment
        // Anda bisa cek path wine di server Anda dengan perintah `which wine`
        $winePath = '/usr/bin/wine';

        // `echo` akan mengirim input ke `stdin` dari wine melalui pipe `|`
        $command = "echo " . escapeshellarg($inputString) . " | " . $winePath . " " . escapeshellarg($executablePath);
        Log::info("[EXEC] >> Menjalankan perintah: " . $command);

        // 2. Eksekusi perintah menggunakan `exec()`
        // `exec` akan menunggu perintah selesai dan memberikan output sebagai array
        $outputLines = [];
        $returnCode = -1;
        exec($command, $outputLines, $returnCode);

        // 3. Cek hasil eksekusi
        if ($returnCode !== 0) {
            Log::error("[EXEC_ERR] >> Perintah gagal dengan kode: {$returnCode}. Output: " . implode("\n", $outputLines));
            return response()->json(['success' => false, 'message' => 'Proses generator gagal dieksekusi.'], 500);
        }

        // 4. Proses output untuk mencari token
        foreach ($outputLines as $line) {
            $trimmedLine = trim($line);
            if (!empty($trimmedLine)) {
                Log::info("[GEN] >> " . $trimmedLine);
                if (preg_match('/Generated token:\s*(.+)/', $trimmedLine, $matches)) {
                    $tokenFinal = trim($matches[1]);
                    break;
                }
            }
        }

        if (!$tokenFinal) {
            Log::error("[GEN_ERR] >> Token tidak ditemukan. Output Penuh: " . implode("\n", $outputLines));
            return response()->json(['success' => false, 'message' => 'Token tidak ditemukan, coba lagi nanti.'], 500);
        }

        // 5. Update kuota user
        $user = \App\Models\User::find($request->user_id);
        if ($type == 'fc2025') {
            $user->decrement('generate_token_quota');
        } elseif ($type == 'fc2026') {
            $user->decrement('generate_token_quota_fc26');
        }

        return response()->json(['success' => true, 'data' => ['token' => $tokenFinal]]);
    }
}

