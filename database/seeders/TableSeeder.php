<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Table;

class TableSeeder extends Seeder
{
    public function run(): void
    {
        $tables = [
            ['restaurant_id' => 1, 'name' => 'T1', 'capacity' => '2 Orang', 'status' => 'available'],
            ['restaurant_id' => 1, 'name' => 'T2', 'capacity' => '2 Orang', 'status' => 'available'],
            ['restaurant_id' => 1, 'name' => 'R1', 'capacity' => '4 - 6 Orang', 'status' => 'available'],
            ['restaurant_id' => 1, 'name' => 'T3', 'capacity' => '2 - 3 Orang', 'status' => 'booked'],
            ['restaurant_id' => 1, 'name' => 'T4', 'capacity' => '2 - 4 Orang', 'status' => 'available'],
            ['restaurant_id' => 1, 'name' => 'R2', 'capacity' => '4 - 6 Orang', 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            Table::updateOrCreate(
                [
                    'restaurant_id' => $table['restaurant_id'], 
                    'name' => $table['name']
                ],
                $table
            );
        }
    }
}