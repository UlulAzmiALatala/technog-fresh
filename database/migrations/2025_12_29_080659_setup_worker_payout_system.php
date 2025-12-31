<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Buat Tabel Workers
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->text('bank_info')->nullable(); // Untuk info rekening/e-wallet
            $table->string('specialization')->nullable(); // e.g. UI/UX, Backend
            $table->timestamps();
        });

        // 2. Update Tabel Expenses (Tambahkan Foreign Key)
        Schema::table('expenses', function (Blueprint $table) {
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');
            $table->foreignId('worker_id')->nullable()->constrained('workers')->onDelete('set null');
            // Type 'project' atau 'operational' sudah ada di model Anda, tinggal kita manfaatkan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
