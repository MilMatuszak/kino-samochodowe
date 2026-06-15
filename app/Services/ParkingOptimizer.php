<?php

namespace App\Services;

use App\Models\ParkingSpot;
use App\Models\Reservation;

/**
 * Algorytm optymalizacji rozmieszczenia pojazdów (klasa OptymalizacjaAlokacji z diagramu klas).
 *
 * Zasada działania:
 * - duże pojazdy (van, suv) trafiają na tylne rzędy, aby nie zasłaniać ekranu mniejszym autom,
 * - małe pojazdy (osobowy, motocykl) trafiają bliżej ekranu (przednie rzędy),
 * - w obrębie rzędu miejsca przydzielane są kolejno.
 *
 * Dzięki temu maksymalizujemy widoczność i wykorzystanie przestrzeni.
 */
class ParkingOptimizer
{
    // Waga gabarytu — im większy pojazd, tym dalej od ekranu
    private static array $wagaGabarytu = [
        'motocykl' => 1,
        'osobowy'  => 2,
        'suv'      => 3,
        'van'      => 4,
    ];

    /**
     * Generuje propozycję rozmieszczenia dla aktywnych rezerwacji danego seansu.
     * Zwraca tablicę: [reservation_id => parking_spot_id].
     */
    public static function generujPropozycje(int $seanceId): array
    {
        $rezerwacje = Reservation::where('seance_id', $seanceId)
            ->whereIn('status', ['oczekujaca', 'potwierdzona'])
            ->get();

        // Wszystkie miejsca pogrupowane wg rzędu (1 = przód/ekran, 5 = tył)
        $miejscaWgRzedu = ParkingSpot::orderBy('rzad')->orderBy('kolumna')
            ->get()
            ->groupBy('rzad');

        $maxRzad = $miejscaWgRzedu->keys()->max() ?: 1;

        // Preferowany rząd dla danego gabarytu (motocykl → przód, van → tył)
        $preferencjaRzedu = function (string $pojazd) use ($maxRzad): int {
            return match ($pojazd) {
                'motocykl' => 1,
                'osobowy'  => (int) ceil($maxRzad * 0.4),  // ok. 40% w głąb
                'suv'      => (int) ceil($maxRzad * 0.7),   // ok. 70% w głąb
                'van'      => $maxRzad,                       // ostatni rząd
                default    => (int) ceil($maxRzad * 0.4),
            };
        };

        // Śledzimy które miejsca są już zajęte przez propozycję
        $uzyte = [];
        $propozycja = [];

        foreach ($rezerwacje as $rez) {
            $start = $preferencjaRzedu($rez->rodzaj_pojazdu);
            $spot  = null;

            // Szukaj wolnego miejsca: od preferowanego rzędu, potem sąsiednie
            for ($odleglosc = 0; $odleglosc < $maxRzad && !$spot; $odleglosc++) {
                foreach ([$start + $odleglosc, $start - $odleglosc] as $rzad) {
                    if ($rzad < 1 || $rzad > $maxRzad) continue;
                    $kandydaci = $miejscaWgRzedu->get($rzad);
                    if (!$kandydaci) continue;
                    foreach ($kandydaci as $m) {
                        if (!in_array($m->id, $uzyte)) {
                            $spot = $m;
                            break 2;
                        }
                    }
                }
            }

            if ($spot) {
                $uzyte[] = $spot->id;
                $propozycja[$rez->id] = $spot->id;
            }
        }

        return $propozycja;
    }

    /**
     * Zlicza statystyki propozycji (do wyświetlenia pracownikowi).
     */
    public static function statystyki(array $propozycja): array
    {
        return [
            'przydzielono'   => count($propozycja),
            'wykorzystanie'  => ParkingSpot::count() > 0
                ? round(count($propozycja) / ParkingSpot::count() * 100)
                : 0,
        ];
    }
}
