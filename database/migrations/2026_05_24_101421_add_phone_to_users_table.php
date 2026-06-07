<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhoneToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $collection) {
            // Kita tambahkan kolom phone setelah kolom email, dan set nullable (boleh kosong) dulu biar aman
            $collection->string('phone')->nullable()->after('email');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $collection) {
            // Untuk merollback jika ada pembatalan
            $collection->dropColumn('phone');
        });
    }
}