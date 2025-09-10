<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use HasFactory, Notifiable;

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'carts')
            ->withPivot('quantity');
    }



    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
