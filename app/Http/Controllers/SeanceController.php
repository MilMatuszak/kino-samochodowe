<?php

namespace App\Http\Controllers;

use App\Models\{Seance, Film};
use Illuminate\Http\Request;
use App\Services\NotificationService;
use App\Services\ParkingOptimizer;
use App\Models\ParkingSpot;
use App\Models\Reservation;

class SeanceController extends Controller
{
    public function index()
    {
        $seances = Seance::nadchodzace()->with('film')->paginate(20);
        return view('seances.index', compact('seances'));
    }

    public function adminIndex()
    {
        $seances = Seance::with('film')->latest('data')->paginate(20);
        return view('admin.seances.index', compact('seances'));
    }

    public function create()
    {
        $films = Film::aktywne()->get();
        return view('admin.seances.create', compact('films'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'film_id'             => 'required|exists:films,id',
            'data'                => 'required|date|after:today',
            'godzina_rozpoczecia' => 'required',
            'ekran_projekcyjny'   => 'required|string',
            'cena_biletu'         => 'required|numeric|min:1',
        ]);

        $konflikt = Seance::where('ekran_projekcyjny', $data['ekran_projekcyjny'])
            ->where('data', $data['data'])
            ->where('godzina_rozpoczecia', $data['godzina_rozpoczecia'])
            ->exists();

        if ($konflikt) {
            return back()->withErrors(['godzina_rozpoczecia' => 'Konflikt terminów na tym ekranie.']);
        }

        Seance::create($data);
        return redirect()->route('admin.seances.index')->with('success', 'Seans dodany.');
    }

    public function destroy(Seance $seance)
    {
        $seance->update(['status' => 'odwolany']);
        foreach ($seance->reservations()->where('status', '!=', 'anulowana')->with('user')->get() as $rez) {
            NotificationService::wyslij(
                $rez->user,
                'email',
                'Odwołanie seansu',
                "Seans filmu \"{$seance->film->tytul}\" z dnia {$seance->data} został odwołany. Przepraszamy za niedogodności."
            );
        }
        return redirect()->route('admin.seances.index')->with('success', 'Seans odwołany.');
    }

    // Podgląd propozycji optymalizacji dla seansu
    public function optymalizacja(Seance $seance)
    {
        $propozycja = ParkingOptimizer::generujPropozycje($seance->id);
        $statystyki = ParkingOptimizer::statystyki($propozycja);

        // Przygotuj czytelne dane do widoku: rezerwacja → miejsce
        $przydzialy = [];
        foreach ($propozycja as $reservationId => $spotId) {
            $rez   = Reservation::with('user')->find($reservationId);
            $spot  = ParkingSpot::find($spotId);
            $przydzialy[] = [
                'klient'  => $rez->user->imie_nazwisko ?? '—',
                'pojazd'  => ucfirst($rez->rodzaj_pojazdu),
                'miejsce' => $spot->numer_miejsca ?? '—',
            ];
        }

        return view('panel.parking.optymalizacja', compact('seance', 'przydzialy', 'statystyki'));    }

    // Zatwierdzenie propozycji — zapisuje przydziały
    public function zatwierdzOptymalizacje(Seance $seance)
    {
        $propozycja = ParkingOptimizer::generujPropozycje($seance->id);

        foreach ($propozycja as $reservationId => $spotId) {
            Reservation::where('id', $reservationId)->update(['parking_spot_id' => $spotId]);
            ParkingSpot::where('id', $spotId)->update(['status' => 'zajete']);
        }

        return redirect()->route('panel.parking.index')
            ->with('success', 'Optymalizacja zatwierdzona — miejsca zostały przydzielone.');
    }

    // Lista seansów dla pracownika (do optymalizacji parkingu)
    public function parkingIndex()
    {
        $seances = Seance::with('film')
            ->where('status', '!=', 'odwolany')
            ->orderBy('data')
            ->orderBy('godzina_rozpoczecia')
            ->paginate(20);

        return view('panel.parking.index', compact('seances'));
    }
}
