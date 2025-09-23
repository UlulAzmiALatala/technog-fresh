<?php
// Lokasi: database/seeders/OrderSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\Order;
use App\Models\DetailOrder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cari user Client
        $client = User::whereHas('roles', function ($query) {
            $query->where('name', 'Client');
        })->first();

        // Cari beberapa layanan yang sudah ada
        $websiteService = Service::where('name', 'Pembuatan Website Company Profile')->first();
        $logoService = Service::where('name', 'Jasa Desain Logo Profesional')->first();

        // Pastikan client dan layanan ditemukan
        if ($client && $websiteService && $logoService) {
            // 1. Buat Order baru untuk client
            $order = Order::create([
                'user_id' => $client->id,
                'order_date' => now()->subDays(3),
                'total_price' => 0, // Akan kita update nanti
                'status' => 'Diproses',
            ]);

            // 2. Buat Detail Order untuk layanan website
            DetailOrder::create([
                'order_id' => $order->id,
                'service_id' => $websiteService->id,
                'quantity' => 1,
                'price' => $websiteService->price,
            ]);

            // 3. Buat Detail Order untuk layanan logo
            DetailOrder::create([
                'order_id' => $order->id,
                'service_id' => $logoService->id,
                'quantity' => 1,
                'price' => $logoService->price,
            ]);

            // 4. Hitung dan update total harga di order utama
            $totalPrice = $order->detailOrders()->sum('price');
            $order->update(['total_price' => $totalPrice]);
        }
    }
}
