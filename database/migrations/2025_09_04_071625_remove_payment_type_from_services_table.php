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
            // Hapus kolom payment_type jika ada
            if (Schema::hasColumn('services', 'payment_type')) {
                $table->dropColumn('payment_type');
            }
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
            // Untuk membatalkan perubahan jika diperlukan
            $table->string('payment_type')->nullable()->after('package_plan');
        });
    }
};
