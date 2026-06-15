<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['food_order_id', 'food_product_id', 'ilosc', 'cena_jednostkowa'];

    public function foodOrder()   { return $this->belongsTo(FoodOrder::class); }
    public function foodProduct() { return $this->belongsTo(FoodProduct::class); }

    public function wartoscLaczna(): float
    {
        return $this->cena_jednostkowa * $this->ilosc;
    }
}
