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
        Schema::create('ai_chat_logs', function (Blueprint $table) {
            $table->id();
            $table->text('user_message');
            $table->text('ai_response');
            $table->string('ip_address')->nullable(); // Untuk melacak IP si penanya
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_chat_logs');
    }
};
