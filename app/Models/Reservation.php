<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Ini kunci rahasianya bos! 
    // Guarded kosong artinya kita mengizinkan semua kolom untuk diisi (Mass Assignment)
    protected $guarded = [];protected $fillable = [
    'user_id',          
    'restaurant_id',
    'table_id',
    'customer_name',
    'customer_email',   
    'customer_phone',
    'reservation_date',
    'reservation_time',
    'guests',
    'notes',
    'subtotal',
    'tax',
    'service_charge',
    'total_price',
    'status',
    'snap_token',
    'payment_method'
]; 
// Tambahkan relasi ini di dalam class Reservation
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class, 'restaurant_id', 'id');
    }
}

