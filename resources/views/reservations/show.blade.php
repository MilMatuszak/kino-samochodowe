@extends('layouts.app')
@section('title', 'Twój bilet')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl p-1">
            <div class="bg-gray-900 rounded-xl p-6">
                <div class="text-center mb-4">
                    <p class="text-yellow-400 text-xs uppercase tracking-widest mb-1">Bilet elektroniczny</p>
                    <h1 class="text-2xl font-bold text-white">{{ $reservation->seance->film->tytul }}</h1>
                </div>

                <div class="flex justify-center my-6">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ $reservation->ticket->kod_qr ?? 'brak' }}" alt="Kod QR" class="rounded-lg bg-white p-2">
                </div>

                <div class="space-y-2 text-sm border-t border-gray-800 pt-4">
                    <div class="flex justify-between"><span class="text-gray-400">Data</span><span class="text-white">{{ \Carbon\Carbon::parse($reservation->seance->data)->format('d.m.Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Godzina</span><span class="text-white">{{ \Carbon\Carbon::parse($reservation->seance->godzina_rozpoczecia)->format('H:i') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Miejsce</span><span class="text-white">{{ $reservation->parkingSpot->numer_miejsca ?? '—' }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Pojazd</span><span class="text-white">{{ ucfirst($reservation->rodzaj_pojazdu) }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Bilet</span><span class="text-white">{{ ucfirst($reservation->ticket->rodzaj_znizki ?? '—') }}</span></div>
                    <div class="flex justify-between text-base font-bold"><span class="text-gray-300">Cena</span><span class="text-yellow-400">{{ number_format($reservation->ticket->cena ?? 0, 2) }} zł</span></div>
                </div>

                <div class="text-center mt-4">
                <span class="inline-block text-xs px-3 py-1 rounded-full
                    @if($reservation->status === 'potwierdzona') bg-green-900 text-green-300
                    @else bg-yellow-900 text-yellow-300 @endif">
                    {{ ucfirst($reservation->status) }}
                </span>
                    @if($reservation->status === 'oczekujaca')
                        <a href="{{ route('reservations.platnosc', $reservation) }}"
                           class="block text-center bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-bold py-2.5 rounded-lg transition mt-4">
                            Zapłać teraz 💳
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <a href="{{ route('reservations.index') }}" class="block text-center text-gray-400 hover:text-yellow-400 text-sm mt-4">← Moje rezerwacje</a>
    </div>
@endsection
