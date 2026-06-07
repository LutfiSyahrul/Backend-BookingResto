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
        Schema::create('restaurant_galleries', function (Blueprint $table) {
            $table->id();
            // Menyambungkan foto dengan ID restoran (otomatis hapus foto kalau restoran dihapus)
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            // Tempat menyimpan link/nama file foto
            $table->string('image_url'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_galleries');
    }
};
