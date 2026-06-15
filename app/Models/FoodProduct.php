<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodProduct extends Model
{
    protected $fillable = ['nazwa', 'cena', 'dostepnosc', 'kategoria', 'zdjecie'];
    protected $casts    = ['dostepnosc' => 'boolean'];

    public function orderItems() { return $this->hasMany(OrderItem::class); }
    public function scopeDostepne($query) { return $query->where('dostepnosc', true); }
}
