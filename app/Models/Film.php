<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    protected $fillable = [
        'tytul', 'opis', 'czas_trwania', 'wiek_ograniczenie',
        'gatunek', 'plakat', 'aktywny',
    ];

    protected $casts = ['aktywny' => 'boolean'];

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    public function opinions()
    {
        return $this->hasMany(Opinion::class);
    }

    public function srednia_ocena(): float
    {
        return $this->opinions()
            ->where('status_moderacji', 'opublikowana')
            ->avg('ocena') ?? 0;
    }

    public function scopeAktywne($query)
    {
        return $query->where('aktywny', true);
    }
}
