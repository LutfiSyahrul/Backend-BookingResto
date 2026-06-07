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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('platform_name')->default('BookingResto Admin');
            $table->string('contact_email')->default('admin@bookingresto.com');
            $table->string('whatsapp')->default('+62 812-3456-7890');
            $table->decimal('tax_rate', 5, 2)->default(10.00);
            $table->boolean('is_maintenance')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
