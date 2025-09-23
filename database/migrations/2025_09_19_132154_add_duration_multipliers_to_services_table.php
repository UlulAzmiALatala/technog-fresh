<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('services', function (Blueprint $table) {
            // Menambahkan kolom setelah kolom 'price' agar rapi
            $table->decimal('price_fast_multiplier', 5, 2)->nullable()->default(1.25)->after('price');
            $table->decimal('duration_fast_multiplier', 5, 2)->nullable()->default(0.75)->after('price_fast_multiplier');
            $table->decimal('price_express_multiplier', 5, 2)->nullable()->default(1.50)->after('duration_fast_multiplier');
            $table->decimal('duration_express_multiplier', 5, 2)->nullable()->default(0.50)->after('price_express_multiplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'price_fast_multiplier',
                'duration_fast_multiplier',
                'price_express_multiplier',
                'duration_express_multiplier'
            ]);
        });
    }
};

