<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
    'restaurant_id', 
    'kategori', 
    'nama_menu', 
    'deskripsi', 
    'harga', 
    'is_available', 
    'gambar_url'
];
}