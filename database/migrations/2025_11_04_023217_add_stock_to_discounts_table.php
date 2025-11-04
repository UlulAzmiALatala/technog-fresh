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
        Schema::table('discounts', function (Blueprint $table) {
            // "Stok" (Berapa kali bisa dipakai?)
            // Dibuat nullable() agar jika nilainya NULL, berarti tak terbatas.
            $table->integer('max_uses')->unsigned()->nullable()->after('is_active');

            // "Penghitung" (Sudah dipakai berapa kali?)
            $table->integer('current_uses')->unsigned()->default(0)->after('max_uses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('discounts', function (Blueprint $table) {
            $table->dropColumn(['max_uses', 'current_uses']);
        });
    }
};
