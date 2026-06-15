@extends('layouts.app')
@section('title', 'Rezerwacja biletu')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-yellow-400 mb-2">Rezerwacja biletu</h1>
        <p class="text-gray-400 mb-6">
            <strong class="text-white">{{ $seance->film->tytul }}</strong>
            · {{ \Carbon\Carbon::parse($seance->data)->format('d.m.Y') }}
            · {{ \Carbon\Carbon::parse($seance->godzina_rozpoczecia)->format('H:i') }}
            · {{ $seance->ekran_projekcyjny }}
        </p>

        <form action="{{ route('reservations.store', $seance) }}" method="POST">
            @csrf
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-4">
                <h2 class="font-semibold text-white mb-4">Wybierz miejsce parkingowe</h2>
                <div class="bg-gray-950 rounded-lg p-4 mb-4">
                    <p class="text-center text-xs text-gray-500 mb-3 uppercase tracking-widest">🎬 Ekran</p>
                    <div class="bg-gray-950 rounded-lg p-4 mb-4">
                        <p class="text-center text-xs text-gray-500 mb-3 uppercase tracking-widest">🎬 Ekran</p>
                        <div class="flex flex-wrap gap-2 justify-center">
                            @foreach($miejsca as $miejsce)
                                @if($miejsce->status === 'wolne')
                                    <label class="cursor-pointer">
                                        <input type="radio" name="parking_spot_id" value="{{ $miejsce->id }}" class="sr-only peer" required>
                                        <div class="w-14 h-10 flex flex-col items-center justify-center rounded border-2 border-green-700 bg-green-900/30 text-green-400 peer-checked:border-yellow-400 peer-checked:bg-yellow-900/30 peer-checked:text-yellow-300 hover:border-green-400 transition text-xs font-mono">
                                            <span>{{ $miejsce->numer_miejsca }}</span>
                                            <span class="text-[10px] opacity-70">{{ strtoupper(substr($miejsce->typ_pojazdu, 0, 3)) }}</span>
                                        </div>
                                    </label>
                                @else
                                    <div class="w-14 h-10 flex flex-col items-center justify-center rounded border-2 border-red-800 bg-red-900/30 text-red-500 text-xs font-mono cursor-not-allowed opacity-70" title="Miejsce zajęte">
                                        <span>{{ $miejsce->numer_miejsca }}</span>
                                        <span class="text-[10px] opacity-70">{{ strtoupper(substr($miejsce->typ_pojazdu, 0, 3)) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                        {{-- Legenda --}}
                        <div class="flex justify-center gap-4 mt-4 text-xs">
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm border-2 border-green-700 bg-green-900/30"></span><span class="text-gray-400">Wolne</span></span>
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm border-2 border-red-800 bg-red-900/30"></span><span class="text-gray-400">Zajęte</span></span>
                            <span class="flex items-center gap-1.5"><span class="w-3 h-3 rounded-sm border-2 border-yellow-400 bg-yellow-900/30"></span><span class="text-gray-400">Wybrane</span></span>
                        </div>

                        <p class="text-center text-xs text-gray-600 mt-3">🚗 Kliknij wolne miejsce aby wybrać</p>
                    </div>
                    <p class="text-center text-xs text-gray-600 mt-3">🚗 Kliknij miejsce aby wybrać</p>
                </div>
            </div>

            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-4">
                <h2 class="font-semibold text-white mb-4">Szczegóły</h2>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Rodzaj pojazdu</label>
                        <select name="rodzaj_pojazdu" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                            <option value="osobowy">Osobowy</option>
                            <option value="suv">SUV</option>
                            <option value="van">Van</option>
                            <option value="motocykl">Motocykl</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm text-gray-400 mb-1">Zniżka</label>
                        <select name="rodzaj_znizki" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                            <option value="normalny">Normalny — {{ number_format($seance->cena_biletu, 2) }} zł</option>
                            <option value="studencki">Studencki (−40%) — {{ number_format($seance->cena_biletu * 0.6, 2) }} zł</option>
                            <option value="ulgowy">Ulgowy (−50%) — {{ number_format($seance->cena_biletu * 0.5, 2) }} zł</option>
                            <option value="rodzinny">Rodzinny (−20%) — {{ number_format($seance->cena_biletu * 0.8, 2) }} zł</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-bold py-3 rounded-xl transition text-lg">Zarezerwuj bilet 🎟️</button>
        </form>
    </div>
@endsection
