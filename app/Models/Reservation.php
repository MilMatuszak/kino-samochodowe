<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id', 'seance_id', 'parking_spot_id',
        'data_rezerwacji', 'rodzaj_pojazdu', 'status',
    ];

    protected $casts = ['data_rezerwacji' => 'datetime'];

    public function user()        { return $this->belongsTo(User::class); }
    public function seance()      { return $this->belongsTo(Seance::class); }
    public function parkingSpot() { return $this->belongsTo(ParkingSpot::class); }
    public function ticket()      { return $this->hasOne(Ticket::class); }
    public function foodOrders()  { return $this->hasMany(FoodOrder::class); }

    public function moznaAnulowac(): bool
    {
        if (!$this->seance) return false;
        $seanceTime = \Carbon\Carbon::parse($this->seance->data . ' ' . $this->seance->godzina_rozpoczecia);
        return now()->lt($seanceTime->subHours(2))
            && in_array($this->status, ['oczekujaca', 'potwierdzona']);
    }
}
