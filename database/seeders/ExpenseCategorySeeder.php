<?php
// Lokasi: database/seeders/ExpenseCategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseCategory::create(['name' => 'Biaya Operasional']);
        ExpenseCategory::create(['name' => 'Gaji Karyawan']);
        ExpenseCategory::create(['name' => 'Marketing & Iklan']);
        ExpenseCategory::create(['name' => 'Peralatan Kantor']);
    }
}
