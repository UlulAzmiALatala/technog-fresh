<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Buat peran-peran baru
        Role::create(['name' => 'Founder']);
        Role::create(['name' => 'Pemasukan dan Pengeluaran']); // Peran yang digabung
        Role::create(['name' => 'Konten']); // Peran baru
        Role::create(['name' => 'Client']);
    }
}
