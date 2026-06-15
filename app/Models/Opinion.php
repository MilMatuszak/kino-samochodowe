<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opinion extends Model
{
    protected $fillable = ['user_id', 'film_id', 'ocena', 'komentarz', 'status_moderacji'];

    public function user() { return $this->belongsTo(User::class); }
    public function film() { return $this->belongsTo(Film::class); }

    public function scopeOpublikowane($query)
    {
        return $query->where('status_moderacji', 'opublikowana');
    }
}
