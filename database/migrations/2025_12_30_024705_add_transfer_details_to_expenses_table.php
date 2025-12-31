<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            // Menambahkan kolom untuk file bukti dan catatan transfer
            $table->string('transfer_proof')->nullable()->after('status');
            $table->text('transfer_note')->nullable()->after('transfer_proof');
        });
    }

    public function down(): void
    {
        Schema::table('expenses', function (Blueprint $table) {
            $table->dropColumn(['transfer_proof', 'transfer_note']);
        });
    }
};
