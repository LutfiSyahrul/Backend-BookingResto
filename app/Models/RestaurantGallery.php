<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantGallery extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'restaurant_id',
        'image_url',
    ];

    // Relasi balik ke tabel restoran
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}