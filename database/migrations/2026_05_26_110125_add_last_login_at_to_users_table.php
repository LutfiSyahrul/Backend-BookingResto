<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kita buatkan sekalian kolom status (default 'active') dan last_login_at
            // Ditaruh setelah kolom password agar rapi
            $table->string('status')->default('active')->after('password');
            $table->timestamp('last_login_at')->nullable()->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'last_login_at']);
        });
    }
};