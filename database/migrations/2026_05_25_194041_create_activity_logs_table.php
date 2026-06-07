<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('subject_name'); // Contoh: "Osteria Francescana" atau "Lutfi"
            $table->string('subject_type'); // Contoh: "Registrasi Restoran" atau "Registrasi User"
            $table->string('activity_type'); // Contoh: "Onboarding", "Account Creation"
            $table->string('status'); // Contoh: "Verified", "Pending Review", "Approved"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
