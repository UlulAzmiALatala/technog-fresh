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
            // [PERBAIKAN] Daftar kolom lama yang ingin dihapus
            $columnsToDrop = [
                'user_id',
                'estimasi_pengerjaan',
                'satuan_waktu',
                'category_name',
                'category_slug',
                'package_type'
            ];

            // Pendekatan Aman: Cek setiap kolom sebelum mencoba menghapusnya
            foreach ($columnsToDrop as $column) {
                if (Schema::hasColumn('services', $column)) {
                    // Jika kolomnya adalah user_id, hapus foreign key-nya dulu
                    if ($column === 'user_id') {
                        $table->dropForeign(['user_id']);
                    }
                    $table->dropColumn($column);
                }
            }

            // Setelah kolom lama aman dihapus, tambahkan semua kolom baru
            if (!Schema::hasColumn('services', 'category_id')) {
                $table->foreignId('category_id')->nullable()->after('id')->constrained('categories')->onDelete('set null');
            }
            if (!Schema::hasColumn('services', 'package_plan')) {
                $table->string('package_plan')->nullable()->after('name');
            }
            if (!Schema::hasColumn('services', 'payment_type')) {
                $table->string('payment_type')->nullable()->after('package_plan');
            }
            if (!Schema::hasColumn('services', 'estimated_duration')) {
                $table->integer('estimated_duration')->nullable()->after('price');
            }
            if (!Schema::hasColumn('services', 'duration_unit')) {
                $table->string('duration_unit')->nullable()->after('estimated_duration');
            }
            if (!Schema::hasColumn('services', 'features')) {
                $table->text('features')->nullable()->after('description');
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
            // Logika untuk mengembalikan perubahan (jika di-rollback)
            if (Schema::hasColumn('services', 'category_id')) {
                $table->dropForeign(['category_id']);
            }

            $table->dropColumn([
                'category_id',
                'package_plan',
                'payment_type',
                'estimated_duration',
                'duration_unit',
                'features'
            ]);

            // Buat kembali kolom-kolom lama
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->integer('estimasi_pengerjaan')->nullable();
            $table->string('satuan_waktu')->nullable();
            $table->string('category_name')->nullable();
            $table->string('category_slug')->nullable();
            $table->string('package_type')->nullable();
        });
    }
};
