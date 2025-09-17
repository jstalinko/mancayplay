<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tutorial;         // 1. Import model Tutorial
use Faker\Factory as Faker;      // 2. Import Faker

class TutorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Inisialisasi Faker untuk membuat data palsu
        $faker = Faker::create('id_ID');

        // Daftar contoh link YouTube
        $youtubeLinks = [
            'https://www.youtube.com/embed/dQw4w9WgXcQ',
            'https://www.youtube.com/embed/hFBjTEWktOo',
            'https://www.youtube.com/embed/Q3K0TOvTOno',
        ];

        // Loop untuk membuat 15 data tutorial
        for ($i = 0; $i < 15; $i++) {
            Tutorial::create([
                'title' => $faker->sentence(4), // Membuat judul dari 4 kata acak
                'content' => $faker->paragraphs(3, true), // Membuat 3 paragraf konten
                
                // Secara acak, 1 dari 3 kemungkinan akan punya link youtube, sisanya null
                'embed_youtube' => (rand(0, 2) === 0) ? $faker->randomElement($youtubeLinks) : null,
            ]);
        }
    }
}