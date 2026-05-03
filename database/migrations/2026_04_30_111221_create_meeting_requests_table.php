<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('meeting_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact'); // Menyimpan nomor WA atau Email
            $table->string('meeting_type'); // Online atau Offline
            $table->text('topic')->nullable();

            // Kolom status untuk Admin memonitor prospek
            // Pilihan: 'pending', 'contacted', 'scheduled', 'completed', 'canceled'
            $table->string('status')->default('pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meeting_requests');
    }
};
