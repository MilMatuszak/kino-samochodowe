<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodOrder extends Model
{
    protected $fillable = [
        'user_id', 'reservation_id', 'czas_zlozenia',
        'platnosc', 'suma', 'status',
    ];

    protected $casts = ['czas_zlozenia' => 'datetime'];

    public function user()        { return $this->belongsTo(User::class); }
    public function reservation() { return $this->belongsTo(Reservation::class); }
    public function items()       { return $this->hasMany(OrderItem::class); }

    public function przeliczSume(): void
    {
        $suma = $this->items->sum(fn($i) => $i->cena_jednostkowa * $i->ilosc);
        $this->update(['suma' => $suma]);
    }
}
