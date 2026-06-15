<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParkingSpot extends Model
{
    protected $fillable = ['numer_miejsca', 'typ_pojazdu', 'status', 'rzad', 'kolumna'];

    public function reservations() { return $this->hasMany(Reservation::class); }

    public function scopeWolne($query)  { return $query->where('status', 'wolne'); }
    public function scopeZajete($query) { return $query->where('status', 'zajete'); }

    public function zajmij(): void
    {
        $this->update(['status' => 'zarezerwowane']);
    }

    public function zwolnij(): void
    {
        $this->update(['status' => 'wolne']);
    }
}
