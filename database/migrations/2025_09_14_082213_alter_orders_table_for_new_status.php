<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Menambahkan 'Menunggu Konfirmasi' ke dalam daftar ENUM yang ada
            $table->enum('status', [
                'Menunggu Pembayaran',
                'Menunggu Konfirmasi', // <-- Nilai baru ditambahkan
                'Diproses',
                'Selesai',
                'Dibatalkan'
            ])->default('Menunggu Pembayaran')->change();
        });
    }

    public function down(): void
    {
        // ... (opsional, bisa dibiarkan)
    }
};
