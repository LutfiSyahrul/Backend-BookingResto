<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            // Menggunakan float untuk menyimpan persentase posisi (0.00 - 100.00)
            // Ini RAHASIA UTAMA agar denah meja otomatis RESPONSIF di semua ukuran layar!
            $table->float('pos_x')->default(0)->after('status');
            $table->float('pos_y')->default(0)->after('pos_x');
            
            // Dimensi ukuran meja (opsional jika admin ingin mengubah ukuran meja)
            $table->integer('width')->default(100)->after('pos_y');
            $table->integer('height')->default(100)->after('width');
            
            // Bentuk meja: rectangle (kotak) atau circle (bulat) sesuai desain figma bos
            $table->enum('shape', ['rectangle', 'circle'])->default('rectangle')->after('height');
        });
    }

    public function down(): void
    {
        Schema::table('tables', function (Blueprint $table) {
            $table->dropColumn(['pos_x', 'pos_y', 'width', 'height', 'shape']);
        });
    }
};