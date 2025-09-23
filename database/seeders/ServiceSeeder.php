<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\Category; // Pastikan model Category ada dan di-import

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Cek apakah ada kategori, jika tidak ada, buat beberapa contoh
        if (Category::count() == 0) {
             Category::factory()->count(3)->create();
        }
        $categoryIds = Category::pluck('id');

        Service::create([
            'category_id' => $categoryIds->random(),
            'name' => 'Pembuatan Website Company Profile',
            'package_plan' => 'Basic',
            'price' => 5000000,
            'estimated_duration' => 14,
            'duration_unit' => 'Hari',
            'description' => 'Paket lengkap pembuatan website untuk profil perusahaan dengan desain modern dan responsif.',
            'features' => json_encode(['5 Halaman Statis', 'Desain Responsif', 'Formulir Kontak', 'Integrasi Media Sosial']),
        ]);

        Service::create([
            'category_id' => $categoryIds->random(),
            'name' => 'Jasa Desain Logo Profesional',
            'package_plan' => 'Standard',
            'price' => 1500000,
            'estimated_duration' => 5,
            'duration_unit' => 'Hari',
            'description' => 'Desain logo unik dan profesional untuk brand Anda, termasuk beberapa revisi.',
            'features' => json_encode(['3 Konsep Awal', 'Revisi 5x', 'File Master (AI, EPS)', 'Panduan Brand Sederhana']),
        ]);

        Service::create([
            'category_id' => $categoryIds->random(),
            'name' => 'Manajemen Media Sosial Bulanan',
            'package_plan' => 'Premium',
            'price' => 3000000,
            'estimated_duration' => 30,
            'duration_unit' => 'Hari',
            'description' => 'Pengelolaan akun media sosial (Instagram & Facebook) secara profesional untuk meningkatkan engagement.',
            'features' => json_encode(['12 Desain Feed', '4 Desain Story', 'Riset Hashtag', 'Laporan Performa Bulanan']),
        ]);
    }
}

