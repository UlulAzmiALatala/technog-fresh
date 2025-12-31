<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Kita ubah tipe datanya menjadi string biasa 
            // agar bisa menerima 'Unpaid', 'Paid', dsb.
            $table->string('status')->default('Unpaid')->change();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            // Jika mau dikembalikan ke ENUM (opsional)
            $table->enum('status', ['Belum Lunas', 'Lunas', 'Kadaluarsa'])->change();
        });
    }
};
