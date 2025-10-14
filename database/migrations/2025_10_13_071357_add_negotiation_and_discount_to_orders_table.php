<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Untuk menyimpan harga negosiasi dari admin
            $table->decimal('negotiated_price_fast', 15, 2)->nullable()->after('total_price');
            $table->decimal('negotiated_price_express', 15, 2)->nullable()->after('negotiated_price_fast');

            // Untuk menyimpan data diskon
            $table->string('discount_code')->nullable()->after('status');
            $table->decimal('discount_amount', 15, 2)->default(0)->after('discount_code');
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
