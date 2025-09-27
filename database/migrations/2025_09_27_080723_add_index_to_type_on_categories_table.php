<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Menambahkan indeks pada kolom 'type'
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            // Menghapus indeks jika rollback
            $table->dropIndex(['type']);
        });
    }
};
