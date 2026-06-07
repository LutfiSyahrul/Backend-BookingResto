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
        Schema::table('reservation_items', function (Blueprint $table) {
            // Menyuntikkan kolom is_served tepat di bawah kolom quantity
            $table->boolean('is_served')->default(false)->after('quantity');
        });
    }

    public function down()
    {
        Schema::table('reservation_items', function (Blueprint $table) {
            $table->dropColumn('is_served');
        });
    }
};
