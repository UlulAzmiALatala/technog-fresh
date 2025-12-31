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
        Schema::table('orders', function (Blueprint $table) {
            // Mengubah kolom yang sudah ada untuk memastikan presisi decimalnya
            $table->decimal('total_price', 15, 2)->change();
            $table->decimal('discount_amount', 15, 2)->default(0)->change();
            $table->decimal('negotiated_price_fast', 15, 2)->nullable()->change();
            $table->decimal('negotiated_price_express', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
