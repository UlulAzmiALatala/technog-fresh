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
        // Cek dulu, kalau belum ada baru buat
        if (!Schema::hasTable('workers')) {
            Schema::create('workers', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('email')->nullable();
                $table->text('bank_info')->nullable();
                $table->timestamps();
            });
        }

        // Update Tabel Expenses dengan pengecekan kolom
        Schema::table('expenses', function (Blueprint $table) {
            if (!Schema::hasColumn('expenses', 'order_id')) {
                $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('cascade');
            }
            if (!Schema::hasColumn('expenses', 'worker_id')) {
                $table->foreignId('worker_id')->nullable()->constrained('workers')->onDelete('set null');
            }
            if (!Schema::hasColumn('expenses', 'status')) {
                $table->string('status')->default('Pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
