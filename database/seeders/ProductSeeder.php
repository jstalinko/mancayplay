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
            [
                'name' => 'Template Presentasi \'Elevate\'',
                'image' => 'https://placehold.co/600x400/5d4037/FFFFFF?text=Elevate',
                'active' => true,
            ],
            [
                'name' => 'Paket Ikon Flat \'Simplicity\'',
                'image' => 'https://placehold.co/600x400/8d6e63/FFFFFF?text=Simplicity',
                'active' => true,
            ],
            [
                'name' => 'Font Script Modern \'Signature\'',
                'image' => 'https://placehold.co/600x400/efebe9/333333?text=Signature',
                'active' => true,
            ],
            [
                'name' => 'Mockup Social Media \'Engage\'',
                'image' => 'https://placehold.co/600x400/5d4037/FFFFFF?text=Engage',
                'active' => true,
            ],
            [
                'name' => 'Filter Foto Vintage \'Nostalgia\'',
                'image' => 'https://placehold.co/600x400/8d6e63/FFFFFF?text=Nostalgia',
                'active' => false, // Contoh produk yang tidak aktif
            ],
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

