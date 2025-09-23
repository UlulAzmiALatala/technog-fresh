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
        Schema::table('expenses', function (Blueprint $table) {
            // 1. Hapus aturan foreign key yang lama (namanya kita ambil dari pesan error)
            $table->dropForeign('expenses_category_id_foreign');

            // 2. Buat aturan foreign key yang baru yang menunjuk ke tabel 'categories'
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade'); // Opsional: Hapus pengeluaran jika kategorinya dihapus
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Ini untuk membatalkan perubahan jika diperlukan
            $table->dropForeign(['category_id']);

            // Membuat kembali foreign key yang lama
            $table->foreign('category_id', 'expenses_category_id_foreign')
                ->references('id')
                ->on('expense_categories')
                ->onDelete('cascade');
        });
    }
};
