<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('meeting_requests', function (Blueprint $table) {
            // Menambahkan kolom date dan time setelah meeting_type
            $table->date('meeting_date')->nullable()->after('meeting_type');
            $table->time('meeting_time')->nullable()->after('meeting_date');
        });
    }

    public function down(): void
    {
        Schema::table('meeting_requests', function (Blueprint $table) {
            $table->dropColumn(['meeting_date', 'meeting_time']);
        });
    }
};
