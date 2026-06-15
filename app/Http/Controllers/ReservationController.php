<?php

namespace App\Http\Controllers;

use App\Models\{Reservation, Seance, ParkingSpot, Ticket};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\NotificationService;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Auth::user()->reservations()
            ->with(['seance.film', 'parkingSpot', 'ticket'])
            ->latest()
            ->paginate(10);
        return view('reservations.index', compact('reservations'));
    }

    public function create(Seance $seance)
    {
        $miejsca = ParkingSpot::orderBy('rzad')->orderBy('kolumna')->get();

        if ($miejsca->where('status', 'wolne')->isEmpty()) {
            return back()->with('error', 'Brak wolnych miejsc parkingowych na ten seans.');
        }

        return view('reservations.create', compact('seance', 'miejsca'));
    }

    public function store(Request $request, Seance $seance)
    {
        $request->validate([
            'parking_spot_id' => 'required|exists:parking_spots,id',
            'rodzaj_pojazdu'  => 'required|in:osobowy,suv,van,motocykl',
            'rodzaj_znizki'   => 'required|in:normalny,ulgowy,rodzinny,studencki',
        ]);

        $spot = ParkingSpot::findOrFail($request->parking_spot_id);

        if ($spot->status !== 'wolne') {
            return back()->with('error', 'Wybrane miejsce jest już zajęte.');
        }

        $cena = match($request->rodzaj_znizki) {
            'ulgowy'    => $seance->cena_biletu * 0.50,
            'rodzinny'  => $seance->cena_biletu * 0.80,
            'studencki' => $seance->cena_biletu * 0.60,
            default     => $seance->cena_biletu,
        };

        $reservation = Reservation::create([
            'user_id'         => Auth::id(),
            'seance_id'       => $seance->id,
            'parking_spot_id' => $spot->id,
            'data_rezerwacji' => now(),
            'rodzaj_pojazdu'  => $request->rodzaj_pojazdu,
            'status'          => 'oczekujaca',
        ]);

        Ticket::create([
            'reservation_id' => $reservation->id,
            'kod_qr'         => Str::uuid(),
            'cena'           => $cena,
            'rodzaj_znizki'  => $request->rodzaj_znizki,
        ]);

        $spot->zajmij();

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Rezerwacja utworzona! Przejdź do płatności.');
    }

    public function show(Reservation $reservation)
    {
        abort_if($reservation->user_id !== Auth::id(), 403);
        return view('reservations.show', compact('reservation'));
    }

    public function cancel(Reservation $reservation)
    {
        abort_if($reservation->user_id !== Auth::id(), 403);

        if (!$reservation->moznaAnulowac()) {
            return back()->with('error', 'Rezerwacji nie można już anulować (mniej niż 2h do seansu).');
        }

        $reservation->update(['status' => 'anulowana']);
        $reservation->parkingSpot?->zwolnij();

        return redirect()->route('reservations.index')->with('success', 'Rezerwacja anulowana.');
    }
    // Ekran płatności (mock)
    public function platnosc(Reservation $reservation)
    {
        abort_if($reservation->user_id !== \Illuminate\Support\Facades\Auth::id(), 403);

        if ($reservation->status !== 'oczekujaca') {
            return redirect()->route('reservations.show', $reservation)
                ->with('error', 'Ta rezerwacja nie wymaga płatności.');
        }

        return view('reservations.platnosc', compact('reservation'));
    }

    // Przetwarzanie płatności (mock — symulacja)
    public function zaplac(Request $request, Reservation $reservation)
    {
        abort_if($reservation->user_id !== \Illuminate\Support\Facades\Auth::id(), 403);

        $request->validate([
            'metoda' => 'required|in:karta,blik,przelew',
        ]);

        // MOCK: w prawdziwym systemie tutaj następuje komunikacja z operatorem płatności
        // (PayU, Stripe). Symulujemy udaną płatność i potwierdzamy rezerwację.
        $reservation->update(['status' => 'potwierdzona']);
        $reservation->parkingSpot?->update(['status' => 'zajete']);
        NotificationService::wyslij(
            $reservation->user,
            'email',
            'Potwierdzenie rezerwacji',
            "Twoja rezerwacja na film \"{$reservation->seance->film->tytul}\" została potwierdzona. Miejsce: {$reservation->parkingSpot?->numer_miejsca}."
        );

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Płatność zaakceptowana! Rezerwacja potwierdzona.');
    }
}
