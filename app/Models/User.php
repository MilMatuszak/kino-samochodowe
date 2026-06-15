<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'imie_nazwisko', 'email', 'haslo', 'rola', 'telefon', 'aktywny',
    ];

    protected $hidden = ['haslo', 'remember_token'];

    protected $casts = ['aktywny' => 'boolean'];

    public function getAuthPassword(): string
    {
        return $this->haslo;
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function foodOrders()
    {
        return $this->hasMany(FoodOrder::class);
    }

    public function opinions()
    {
        return $this->hasMany(Opinion::class);
    }

    public function isAdmin(): bool     { return $this->rola === 'administrator'; }
    public function isKierownik(): bool { return $this->rola === 'kierownik'; }
    public function isPracownik(): bool { return $this->rola === 'pracownik'; }
    public function isKlient(): bool    { return $this->rola === 'klient'; }
    public function isPartner(): bool   { return $this->rola === 'partner'; }
    public function canManage(): bool   { return in_array($this->rola, ['administrator', 'kierownik']); }
}
