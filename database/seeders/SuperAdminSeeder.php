<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // 1. Bersihkan dulu kalau sebelumnya sudah ada biar tidak error duplicate
        User::where('email', 'superadmin@bookingresto.com')->delete();

        // 2. Buat akun Super Admin baru
        User::create([
            'name' => 'Super Admin Bookingresto',
            'email' => 'superadminbookingresto@gmail.com',
            'password' => Hash::make('12345678'), // Jangan lupa ganti password ini setelah login pertama kali
            'role' => 'superadmin', // 
            'phone' => '080000000000',
        ]);
    }
}