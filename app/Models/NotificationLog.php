<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $table = 'notifications_log';

    protected $fillable = [
        'user_id', 'kanal', 'odbiorca', 'temat', 'tresc', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
