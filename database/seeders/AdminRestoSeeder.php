<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Hash;

class AdminRestoSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User Admin Baru
        $admin = User::create([
            'name' => 'Pemilik Lombok Barbar',
            'email' => 'admin.lombokbarbar@gmail.com',
            'password' => Hash::make('12345678'),
            'role' => 'adminresto',
            'phone' => '081234567890',
        ]);

        // 2. Buat Restorannya dan hubungkan ke user_id admin di atas
        Restaurant::create([
        'user_id' => $admin->id,
        'name' => 'Lombok Barbar',
        'slug' => 'lombok-barbar',
        'address' => 'Solo, Jawa Tengah', 
        'description' => 'Restoran dengan sambal super pedas khas nusantara.',
        'category' => 'Indonesian',
        'price_range' => '$$',
        'rating' => 4.8,
        'reviews_count' => 120,
        ]);
    }
}