<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin Bos',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'superadmin',
                'created_at' => now(),
            ],

            [
                'name' => 'Admin Resto Waroeng ',
                'email' => 'admin.waroengjamboel@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'adminresto', 
                'created_at' => now(),
            ],
            
            [
                'name' => 'Customer Setia',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'customer',
                'created_at' => now(),
            ]
        ]);
    }
}