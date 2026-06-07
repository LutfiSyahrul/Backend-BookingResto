<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    protected $fillable = [
    'restaurant_id', 'name', 'capacity', 'status', 'area',
    'pos_x', 'pos_y', 'width', 'height', 'shape' 
    ];

    protected $guarded = []; 
}

