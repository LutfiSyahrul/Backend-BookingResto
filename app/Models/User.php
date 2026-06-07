<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    // 1. Trait digabung jadi satu baris biar rapi dan tidak error ganda
    /** @use HasFactory<UserFactory> */
    use HasApiTokens, HasFactory, Notifiable; 

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'last_login_at',
        'image',
        'avatar_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    
    // Relasi: 1 User (Admin) memiliki 1 Restoran
    public function restaurant()
    {
        return $this->hasOne(Restaurant::class);
    }

    // Relasi: User memiliki banyak Restoran Favorit
    public function favoriteRestaurants()
    {
        return $this->belongsToMany(Restaurant::class, 'user_favorites', 'user_id', 'restaurant_id')->withTimestamps();
    }
}