<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // User yang terkait dengan transaksi (bisa client, bisa admin)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('type', ['Pemasukan', 'Pengeluaran']);
            $table->decimal('amount', 15, 2);
            $table->text('description');
            // Kolom polimorfik untuk merujuk ke Payment atau Expense
            $table->morphs('reference'); // Ini akan membuat reference_id dan reference_type
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
