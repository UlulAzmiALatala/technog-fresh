<?php
// Lokasi: database/seeders/ExpenseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;

class ExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user Founder untuk dijadikan sebagai pencatat pengeluaran
        $founder = User::whereHas('roles', function ($query) {
            $query->where('name', 'Founder');
        })->first();

        // Cari kategori
        $operasional = ExpenseCategory::where('name', 'Biaya Operasional')->first();
        $marketing = ExpenseCategory::where('name', 'Marketing & Iklan')->first();

        if ($founder && $operasional) {
            Expense::create([
                'category_id' => $operasional->id,
                'user_id' => $founder->id,
                'description' => 'Pembayaran langganan internet kantor',
                'amount' => 550000,
                'expense_date' => now()->subDays(10),
            ]);
        }

        if ($founder && $marketing) {
            Expense::create([
                'category_id' => $marketing->id,
                'user_id' => $founder->id,
                'description' => 'Biaya iklan di media sosial',
                'amount' => 1200000,
                'expense_date' => now()->subDays(5),
            ]);
        }
    }
}
