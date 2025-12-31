<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Kita ubah dari ENUM ke STRING supaya bisa nampung status bahasa Inggris
            $table->string('status')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Balikin ke ENUM asli kalau ada apa-apa (Rollback)
            $table->enum('status', [
                'Menunggu Pembayaran',
                'Menunggu Konfirmasi',
                'Diproses',
                'Selesai',
                'Dibatalkan'
            ])->change();
        });
    }
};
