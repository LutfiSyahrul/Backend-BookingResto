<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;
use App\Models\Table;

class Restaurant extends Model
{
    use HasFactory;

    // Sesuaikan dengan kolom bahasa Inggris di database
    protected $fillable = [
        'user_id',
        'name', 
        'slug', 
        'category', 
        'price_range', 
        'rating', 'reviews_count', 'address', 'image', 
        'description', 'status',
        'open_time', 'close_time', 'time_interval'
    ];

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Relasi ke tabel tables (meja)
    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    // Relasi ke tabel restaurant_galleries (Galeri Foto)
    public function galleries()
    {
        return $this->hasMany(RestaurantGallery::class);
    }
}