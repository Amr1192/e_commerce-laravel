<?php

namespace App\Models;
use App\Models\Cart;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
use HasFactory;

protected $fillable = [
    'name',
    'description',
    'category_id',
    'price',
    'quantity',
];

public function category() {
   return $this->belongsTo(Category::class);
}


 public function carts() {
        return $this->hasMany(Cart::class);
    }
 
}
