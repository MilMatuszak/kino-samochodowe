<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    protected $fillable = [
        'film_id', 'data', 'godzina_rozpoczecia',
        'ekran_projekcyjny', 'status', 'cena_biletu',
    ];

    public function film()        { return $this->belongsTo(Film::class); }
    public function reservations(){ return $this->hasMany(Reservation::class); }

    public function wolneMiejsca(): int
    {
        $zajete = $this->reservations()
            ->whereIn('status', ['oczekujaca', 'potwierdzona'])
            ->count();
        return ParkingSpot::count() - $zajete;
    }

    public function scopeNadchodzace($query)
    {
        return $query->where('data', '>=', now()->toDateString())
            ->where('status', '!=', 'odwolany')
            ->orderBy('data')->orderBy('godzina_rozpoczecia');
    }
    // Status wyliczany na podstawie daty/godziny seansu
    public function statusWyswietlany(): string
    {
        // Odwołanie to akcja ręczna — ma pierwszeństwo
        if ($this->status === 'odwolany') {
            return 'Odwołany';
        }

        $poczatek = \Carbon\Carbon::parse(\Carbon\Carbon::parse($this->data)->format('Y-m-d') . ' ' . $this->godzina_rozpoczecia);
        $koniec   = $poczatek->copy()->addMinutes($this->film?->czas_trwania ?? 0);
        $teraz    = now();

        if ($teraz->lt($poczatek)) {
            return 'Zaplanowany';
        }
        if ($teraz->lte($koniec)) {
            return 'W trakcie';
        }
        return 'Zakończony';
    }
}
