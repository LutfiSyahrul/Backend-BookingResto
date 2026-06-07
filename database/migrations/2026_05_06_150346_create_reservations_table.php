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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            // table_id nullable karena meja bisa diset di akhir / disesuaikan admin jika perlu
            $table->foreignId('table_id')->nullable()->constrained('tables')->nullOnDelete(); 
            
            // Data Pelanggan
            $table->string('customer_name');
            $table->string('customer_email')->nullable();
            $table->string('customer_phone');
            
            // Data Jadwal
            $table->date('reservation_date');
            $table->time('reservation_time');
            $table->integer('guests');
            $table->text('notes')->nullable();
            
            // Data Biaya
            $table->integer('subtotal')->default(0);
            $table->integer('tax')->default(0);
            $table->integer('service_charge')->default(0);
            $table->integer('total_price');
            
            // Status Transaksi
            $table->string('status')->default('pending'); // pending, paid, cancelled, completed
            $table->string('payment_url')->nullable(); // Untuk link Midtrans/Payment Gateway nanti
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
