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
        Schema::table('restaurants', function (Blueprint $table) {
            // Menambahkan kolom jam buka, jam tutup, dan interval waktu
            $table->time('open_time')->nullable()->after('description');
            $table->time('close_time')->nullable()->after('open_time');
            $table->integer('time_interval')->default(60)->after('close_time'); // Default 60 menit
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            // Menghapus kolom jika di-rollback
            $table->dropColumn(['open_time', 'close_time', 'time_interval']);
        });
    }
};
