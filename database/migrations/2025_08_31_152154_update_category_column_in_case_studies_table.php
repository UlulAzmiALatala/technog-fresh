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
        Schema::table('case_studies', function (Blueprint $table) {
            // 1. Hapus kolom 'category' yang lama (berisi teks)
            $table->dropColumn('category');

            // 2. Tambahkan kolom 'category_id' yang baru dan hubungkan ke tabel 'categories'
            // Kita buat nullable() untuk keamanan jika ada data lama yang tidak punya kategori
            $table->foreignId('category_id')
                ->nullable()
                ->after('client_name') // Meletakkan kolom setelah client_name
                ->constrained('categories')
                ->onDelete('set null'); // Jika kategori dihapus, kolom ini akan jadi NULL
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_studies', function (Blueprint $table) {
            // Ini untuk membatalkan perubahan jika diperlukan
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            $table->string('category')->after('client_name');
        });
    }
};
