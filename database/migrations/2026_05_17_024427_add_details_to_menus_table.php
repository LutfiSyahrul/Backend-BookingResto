<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // Tambahkan kolom deskripsi dan status ketersediaan
            $table->text('deskripsi')->nullable()->after('nama_menu');
            $table->boolean('is_available')->default(true)->after('harga');
        });
    }

    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'is_available']);
        });
    }
};