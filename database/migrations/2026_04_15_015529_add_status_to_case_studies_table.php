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
        Schema::table('case_studies', function (Blueprint $table) {
            $table->string('status')->default('PUBLISHED')->after('title'); // Sesuaikan posisi 'after' jika perlu
        });
    }

    public function down()
    {
        Schema::table('case_studies', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
