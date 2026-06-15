<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['reservation_id', 'kod_qr', 'cena', 'rodzaj_znizki'];

    public function reservation() { return $this->belongsTo(Reservation::class); }
}
