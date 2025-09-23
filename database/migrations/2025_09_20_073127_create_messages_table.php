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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            // Setiap pesan adalah bagian dari satu percakapan
            $table->foreignId('conversation_id')->constrained('conversations')->onDelete('cascade');
            // Siapa pengirim pesan (bisa klien atau admin)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Isi pesan
            $table->text('body');
            // Tanda pesan sudah dibaca
            $table->timestamp('read_at')->nullable();
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
        Schema::dropIfExists('messages');
    }
};
