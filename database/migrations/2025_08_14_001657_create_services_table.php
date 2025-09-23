<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id(); // PK: id

            // FK: user_id merujuk ke tabel users (untuk mencatat siapa yang membuat/mengelola layanan ini)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            $table->string('name');
            $table->text('description')->nullable(); // Menggunakan text untuk deskripsi yang lebih panjang
            $table->string('image')->nullable(); // Path ke gambar, nullable jika gambar tidak wajib
            $table->integer('estimasi_pengerjaan');
            $table->enum('satuan_waktu', ['Hari', 'Minggu', 'Bulan']); // Membatasi pilihan agar data konsisten
            $table->decimal('price', 15, 2); // Menggunakan decimal untuk presisi angka moneter

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
