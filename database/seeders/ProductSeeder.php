<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama untuk menghindari duplikasi saat seeder dijalankan ulang
        DB::table('products')->truncate();

        // Ganti dengan nomor WhatsApp tujuan Anda (gunakan format internasional tanpa + atau 0)
        $whatsappNumber = '6281234567890';

        $products = [
            [ 'name' => "Template Presentasi 'Elevate'", 'image' => 'https://placehold.co/600x400/5d4037/FFFFFF?text=Elevate', 'active' => true ],
            [ 'name' => "Paket Ikon Flat 'Simplicity'", 'image' => 'https://placehold.co/600x400/8d6e63/FFFFFF?text=Simplicity', 'active' => true ],
            [ 'name' => "Font Script Modern 'Signature'", 'image' => 'https://placehold.co/600x400/efebe9/333333?text=Signature', 'active' => true ],
            [ 'name' => "Mockup Social Media 'Engage'", 'image' => 'https://placehold.co/600x400/5d4037/FFFFFF?text=Engage', 'active' => true ],
            [ 'name' => "Filter Foto Vintage 'Nostalgia'", 'image' => 'https://placehold.co/600x400/8d6e63/FFFFFF?text=Nostalgia', 'active' => false ],
            [ 'name' => "Template CV Kreatif 'Impress'", 'image' => 'https://placehold.co/600x400/3949ab/FFFFFF?text=Impress', 'active' => true ],
            [ 'name' => "Bundle Poster Event 'Vibrant'", 'image' => 'https://placehold.co/600x400/00bcd4/FFFFFF?text=Vibrant', 'active' => true ],
            [ 'name' => "Preset Lightroom 'Fresh'", 'image' => 'https://placehold.co/600x400/43a047/FFFFFF?text=Fresh', 'active' => true ],
            [ 'name' => "Template Feed Instagram 'Glow'", 'image' => 'https://placehold.co/600x400/fbc02d/333333?text=Glow', 'active' => true ],
            [ 'name' => "Font Sans Modern 'Urban'", 'image' => 'https://placehold.co/600x400/616161/FFFFFF?text=Urban', 'active' => true ],
            [ 'name' => "Mockup Banner 'Promo'", 'image' => 'https://placehold.co/600x400/ff7043/FFFFFF?text=Promo', 'active' => true ],
            [ 'name' => "Sticker Pack 'Fun'", 'image' => 'https://placehold.co/600x400/ab47bc/FFFFFF?text=Fun', 'active' => true ],
            [ 'name' => "Template Invoice 'Simple'", 'image' => 'https://placehold.co/600x400/009688/FFFFFF?text=Simple', 'active' => true ],
            [ 'name' => "Preset Video 'Cinematic'", 'image' => 'https://placehold.co/600x400/ffca28/333333?text=Cinematic', 'active' => true ],
            [ 'name' => "Template Brosur 'Minimal'", 'image' => 'https://placehold.co/600x400/8bc34a/FFFFFF?text=Minimal', 'active' => true ],
            [ 'name' => "Font Display 'Bold'", 'image' => 'https://placehold.co/600x400/ff5252/FFFFFF?text=Bold', 'active' => true ],
            [ 'name' => "Mockup Feed TikTok 'Trend'", 'image' => 'https://placehold.co/600x400/3f51b5/FFFFFF?text=Trend', 'active' => true ],
        ];

        // Siapkan array untuk menampung data yang akan di-insert
        $dataToInsert = [];
        $now = now(); // Ambil waktu saat ini sekali saja untuk efisiensi

        foreach ($products as $product) {
            // Buat pesan default untuk link WhatsApp
            $message = urlencode("Halo, saya tertarik dengan produk digital: " . $product['name']);
            
            $dataToInsert[] = [
                'name'       => $product['name'],
                'slug'       => Str::slug($product['name']),
                'link'       => "https://wa.me/{$whatsappNumber}?text={$message}",
                'image'      => $product['image'],
                'active'     => $product['active'],
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Masukkan semua data ke database dalam satu query
        DB::table('products')->insert($dataToInsert);
    }
}

