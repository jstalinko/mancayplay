<?php

namespace App\Http\Controllers;

use App\Models\AkunGmail;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use Inertia\Inertia;

class ReadInboxController extends Controller
{
    public function index(Request $request, $pid = null)
    {
        $pid = $pid ?: $request->pid;
        $product = Product::find($pid);
        
        if (!$product) {
            return Inertia::render('read-inbox', ['errorMsg' => 'Produk tidak ditemukan.']);
        }

        $order = Order::where('customer_email' , auth()->user()->email)->where('product_id',$pid)->first();

        if(!$order) {
            return Inertia::render('read-inbox', [
                'errorMsg' => 'Anda belum melakukan pembelian untuk produk ini',
                'product' => $product
            ]);
        }

        $props['product'] = $product;
        $props['order'] = $order;
        $props['hasAccess'] = true;
        
        return Inertia::render('read-inbox',$props);
    }

    public function fetchEmails(Request $request, $pid)
    {
        $product = Product::find($pid);
        if (!$product) return response()->json(['error' => 'Produk tidak ditemukan.'], 404);

        $order = Order::where('customer_email' , auth()->user()->email)->where('product_id',$pid)->first();
        if(!$order) return response()->json(['error' => 'Akses ditolak.'], 403);

        $imap_creds = AkunGmail::where('id' ,$product->akun_gmail_id)->first();
        if(!$imap_creds) return response()->json(['error' => 'Konfigurasi akun gmail dari produk ini tidak ditemukan.'], 404);

        $hostname = '{' . trim($imap_creds->imap_server) . ':' . trim($imap_creds->imap_port) . '/imap/ssl}INBOX';
        $username = trim($imap_creds->email);
        $password = trim($imap_creds->app_password);

        try {
            $inbox = @imap_open($hostname, $username, $password);
            if (!$inbox) {
                return response()->json(['error' => 'Gagal terhubung ke inbox. Silakan coba lagi.'], 500);
            }

            $subject = $product->get_only_subject ?? '';
            
            if (!empty($subject)) {
                $emails = imap_search($inbox, 'SUBJECT "' . trim($subject) . '"');
            } else {
                $emails = imap_search($inbox, 'ALL');
            }

            $result = [];
            if ($emails) {
                rsort($emails);
                $emails = array_slice($emails, 0, 15);
                foreach ($emails as $email_number) {
                    $overview = imap_fetch_overview($inbox, $email_number, 0);
                    $message = imap_fetchbody($inbox, $email_number, 1);
                    
                    if ($message) {
                         // Decodes quoted-printable or base64 based on encoding if needed, simplest approach:
                         if($overview[0]->encoding ?? 0 == 4) {
                             $message = quoted_printable_decode($message);
                         } elseif($overview[0]->encoding ?? 0 == 3) {
                             $message = base64_decode($message);
                         } 
                    }
                    
                    $sub = $overview[0]->subject ?? '(Tanpa Subjek)';
                    
                    // Extract subject mapping
                    $imap_elements = imap_mime_header_decode($sub);
                    if (count($imap_elements) > 0) {
                        $sub = $imap_elements[0]->text;
                    }

                    $result[] = [
                        'subject' => $sub,
                        'from' => $overview[0]->from ?? 'Unknown',
                        'date' => $overview[0]->date ?? 'Unknown',
                        'body' => mb_convert_encoding($message, 'UTF-8', 'auto')
                    ];
                }
            }
            
            imap_close($inbox);
            return response()->json(['data' => $result]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Kesalahan server saat memuat email.'], 500);
        }
    }
}
