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
        Schema::table('payments', function (Blueprint $table) {
            // Ganti nama kolom 'payment_method' menjadi 'method'
            $table->renameColumn('payment_method', 'method');
            // Tambahkan kolom untuk bukti pembayaran setelah kolom amount
            $table->string('payment_proof')->nullable()->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->renameColumn('method', 'payment_method');
            $table->dropColumn('payment_proof');
        });
    }
};
