<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari peran 'Founder' yang sudah kita buat sebelumnya
        $founderRole = Role::where('name', 'Founder')->first();

        // Pastikan peran Founder ada sebelum membuat user
        if ($founderRole) {
            // Buat user Founder
            $founder = User::create([
                'name' => 'Founder Account',
                'email' => 'founder@technog.com',
                'password' => Hash::make('password'), // Ganti 'password' dengan password yang kuat
            ]);

            // Berikan peran 'Founder' ke user tersebut
            $founder->assignRole($founderRole);
        }

        // Anda bisa menambahkan pembuatan user lain di sini jika perlu
        // Contoh: Membuat user Client
        $clientRole = Role::where('name', 'Client')->first();
        if ($clientRole) {
            $client = User::create([
                'name' => 'Test Client',
                'email' => 'client@technog.com',
                'password' => Hash::make('password'),
            ]);
            $client->assignRole($clientRole);
        }
    }
}
