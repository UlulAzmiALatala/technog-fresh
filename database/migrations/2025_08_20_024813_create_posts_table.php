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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penulis artikel
            // $table->foreignId('category_id')->constrained()->onDelete('cascade'); // Kategori artikel
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable(); // Ringkasan singkat
            $table->longText('body'); // Isi artikel
            $table->string('image')->nullable(); // Gambar utama
            $table->enum('status', ['DRAFT', 'PUBLISHED'])->default('DRAFT');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
