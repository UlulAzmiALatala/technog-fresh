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
        Schema::create('conversations', function (Blueprint $table) {
            $table->id();
            // Klien yang memulai percakapan
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            // Admin yang menangani (bisa null jika belum ada yang merespon)
            $table->foreignId('admin_id')->nullable()->constrained('users')->onDelete('set null');
            // Status percakapan: open, closed
            $table->enum('status', ['open', 'closed'])->default('open');
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
        Schema::dropIfExists('conversations');
    }
};
