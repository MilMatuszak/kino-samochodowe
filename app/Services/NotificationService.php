<?php

namespace App\Services;

use App\Models\NotificationLog;
use App\Models\User;

/**
 * Serwis powiadomień (MOCK).
 * W prawdziwym systemie tutaj następowałaby integracja z bramką e-mail (np. Laravel Mail)
 * oraz bramką SMS (np. Twilio, SMSAPI). Na potrzeby projektu zapisujemy powiadomienia
 * do dziennika, co pozwala zweryfikować poprawność logiki wyzwalania powiadomień.
 */
class NotificationService
{
    public static function wyslij(User $user, string $kanal, string $temat, string $tresc): void
    {
        $odbiorca = $kanal === 'sms'
            ? ($user->telefon ?? 'brak numeru')
            : $user->email;

        NotificationLog::create([
            'user_id'  => $user->id,
            'kanal'    => $kanal,
            'odbiorca' => $odbiorca,
            'temat'    => $temat,
            'tresc'    => $tresc,
            'status'   => 'wyslane',
        ]);
    }
}
