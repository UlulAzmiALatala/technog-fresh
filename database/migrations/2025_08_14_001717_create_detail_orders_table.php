<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_orders', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel orders
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            // Foreign key ke tabel services
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->decimal('price', 15, 2); // Harga per item saat dipesan
            $table->string('document_download')->nullable(); // Link untuk mengunduh hasil
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_orders');
    }
};
