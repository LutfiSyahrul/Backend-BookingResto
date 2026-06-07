<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Restaurant; 

class RestaurantSeeder extends Seeder
{
    public function run()
    {
        // updateOrCreate akan mencari berdasarkan slug. 
        // Kalau sudah ada, dia update. Kalau belum ada, dia buat baru. (Anti Error!)
        Restaurant::updateOrCreate(
            ['slug' => 'waroeng-jamboel'], // Acuan pencarian
            [
                'name'          => 'Waroeng JamboeL',
                'category'      => 'Nusantara • Seafood',
                'price_range'   => 'Rp 10.000 - Rp 100.000',
                'rating'        => 4.8,
                'reviews_count' => 120,
                'address'       => 'Surakarta', 
                'image'         => '/resto-jamboel.jpg',
                'description'   => 'Menyajikan aneka hidangan Nusantara, seafood, ayam kampung, dan bebek dengan cita rasa khas bumbu rempah pilihan.',
                'status'        => 'open'
            ]
        );
    }
}