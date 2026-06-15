<?php

namespace Database\Seeders;

use App\Models\{User, Film, Seance, ParkingSpot, FoodProduct};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // --- Użytkownicy ---
        User::create([
            'imie_nazwisko' => 'Admin Systemu',
            'email'         => 'admin@kino.pl',
            'haslo'         => Hash::make('admin123'),
            'rola'          => 'administrator',
        ]);
        User::create([
            'imie_nazwisko' => 'Jan Kowalski',
            'email'         => 'kierownik@kino.pl',
            'haslo'         => Hash::make('kierownik123'),
            'rola'          => 'kierownik',
        ]);
        User::create([
            'imie_nazwisko' => 'Anna Nowak',
            'email'         => 'pracownik@kino.pl',
            'haslo'         => Hash::make('pracownik123'),
            'rola'          => 'pracownik',
        ]);
        User::create([
            'imie_nazwisko' => 'Marek Testowy',
            'email'         => 'klient@kino.pl',
            'haslo'         => Hash::make('klient123'),
            'rola'          => 'klient',
        ]);

        // --- Filmy ---
        $filmy = [
            ['tytul' => 'Dune: Część Druga',    'opis' => 'Kontynuacja epickiej sagi science-fiction.', 'czas_trwania' => 166, 'gatunek' => 'Sci-Fi', 'wiek_ograniczenie' => 12],
            ['tytul' => 'Oppenheimer',           'opis' => 'Historia ojca bomby atomowej.',              'czas_trwania' => 180, 'gatunek' => 'Dramat', 'wiek_ograniczenie' => 16],
            ['tytul' => 'Spider-Man: Bez drogi do domu', 'opis' => 'Peter Parker zmaga się z multiwersum.', 'czas_trwania' => 148, 'gatunek' => 'Akcja', 'wiek_ograniczenie' => 7],
        ];
        foreach ($filmy as $f) {
            Film::create($f);
        }

        // --- Seanse ---
        $film1 = Film::first();
        Seance::create([
            'film_id'             => $film1->id,
            'data'                => now()->addDay()->toDateString(),
            'godzina_rozpoczecia' => '20:30',
            'ekran_projekcyjny'   => 'Ekran główny',
            'status'              => 'aktywny',
            'cena_biletu'         => 35.00,
        ]);
        Seance::create([
            'film_id'             => $film1->id,
            'data'                => now()->addDays(2)->toDateString(),
            'godzina_rozpoczecia' => '22:00',
            'ekran_projekcyjny'   => 'Ekran główny',
            'status'              => 'aktywny',
            'cena_biletu'         => 35.00,
        ]);

        // --- Miejsca parkingowe (5 rzędów × 8 = 40) ---
        $rzedy = ['A','B','C','D','E'];
        foreach ($rzedy as $ri => $rzad) {
            for ($k = 1; $k <= 8; $k++) {
                ParkingSpot::create([
                    'numer_miejsca' => "$rzad$k",
                    'typ_pojazdu'   => $k <= 6 ? 'osobowy' : 'suv',
                    'status'        => 'wolne',
                    'rzad'          => $ri + 1,
                    'kolumna'       => $k,
                ]);
            }
        }

        // --- Produkty gastronomiczne ---
        $menu = [
            ['nazwa' => 'Popcorn solony (duży)', 'cena' => 18.00, 'kategoria' => 'przekąski'],
            ['nazwa' => 'Popcorn karmelowy',     'cena' => 20.00, 'kategoria' => 'przekąski'],
            ['nazwa' => 'Nachos z serem',        'cena' => 22.00, 'kategoria' => 'przekąski'],
            ['nazwa' => 'Hot Dog',               'cena' => 16.00, 'kategoria' => 'przekąski'],
            ['nazwa' => 'Cola 0.5l',             'cena' =>  9.00, 'kategoria' => 'napoje'],
            ['nazwa' => 'Woda mineralna',        'cena' =>  6.00, 'kategoria' => 'napoje'],
            ['nazwa' => 'Piwo (0.5l)',           'cena' => 14.00, 'kategoria' => 'napoje'],
            ['nazwa' => 'Kawa',                  'cena' => 12.00, 'kategoria' => 'napoje'],
        ];
        foreach ($menu as $p) {
            FoodProduct::create(array_merge($p, ['dostepnosc' => true]));
        }
    }
}
