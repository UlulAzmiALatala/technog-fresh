<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); // PK: id [cite: 3]

            // FK: user_id merujuk ke client yang melakukan pemesanan 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->timestamp('order_date')->useCurrent(); // Tanggal pemesanan 
            $table->decimal('total_price', 15, 2); // Total harga dari semua item di pesanan [cite: 9]

            // Status pesanan 
            $table->enum('status', ['Menunggu Pembayaran', 'Diproses', 'Selesai', 'Dibatalkan'])
                ->default('Menunggu Pembayaran');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
