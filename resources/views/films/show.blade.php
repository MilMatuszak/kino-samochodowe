@extends('layouts.app')
@section('title', $film->tytul)

@section('content')
    <div class="max-w-4xl mx-auto">
        <a href="{{ route('films.index') }}" class="text-gray-400 hover:text-yellow-400 text-sm">← Powrót do repertuaru</a>

        <div class="flex flex-col md:flex-row gap-6 mt-4 mb-8">
            <div class="md:w-1/3">
                @if($film->plakat)
                    <img src="{{ asset('storage/' . $film->plakat) }}" alt="{{ $film->tytul }}" class="w-full rounded-xl">
                @else
                    <div class="w-full h-64 bg-gray-800 rounded-xl flex items-center justify-center text-6xl">🎬</div>
                @endif
            </div>
            <div class="md:w-2/3">
                <h1 class="text-3xl font-bold text-yellow-400 mb-2">{{ $film->tytul }}</h1>
                <div class="flex gap-3 text-sm text-gray-400 mb-4">
                    <span>{{ $film->gatunek }}</span><span>·</span>
                    <span>{{ $film->czas_trwania }} min</span><span>·</span>
                    <span>{{ $film->wiek_ograniczenie === 0 ? 'Bez ograniczeń' : $film->wiek_ograniczenie . '+' }}</span><span>·</span>
                    <span>⭐ {{ number_format($film->srednia_ocena(), 1) }}</span>
                </div>
                <p class="text-gray-300 leading-relaxed">{{ $film->opis }}</p>
            </div>
        </div>

        <h2 class="text-xl font-bold text-white mb-4">Dostępne seanse</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-10">
            @forelse($seances as $seance)
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 flex items-center justify-between">
                    <div>
                        <p class="text-white font-semibold">{{ \Carbon\Carbon::parse($seance->data)->format('d.m.Y') }}</p>
                        <p class="text-gray-400 text-sm">{{ \Carbon\Carbon::parse($seance->godzina_rozpoczecia)->format('H:i') }} · {{ $seance->ekran_projekcyjny }}</p>
                        <p class="text-yellow-400 text-sm mt-1">{{ number_format($seance->cena_biletu, 2) }} zł</p>
                    </div>
                    @auth
                        <a href="{{ route('reservations.create', $seance) }}" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-4 py-2 rounded-lg text-sm transition">Rezerwuj</a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-400 text-sm hover:text-yellow-400">Zaloguj, by rezerwować</a>
                    @endauth
                </div>
            @empty
                <p class="text-gray-500 col-span-2">Brak zaplanowanych seansów dla tego filmu.</p>
            @endforelse
        </div>

        <h2 class="text-xl font-bold text-white mb-4">Opinie</h2>
        @auth
            <form action="{{ route('opinions.store', $film) }}" method="POST" class="bg-gray-900 border border-gray-800 rounded-xl p-4 mb-6">
                @csrf
                <div class="mb-3">
                    <label class="block text-sm text-gray-400 mb-1">Ocena</label>
                    <select name="ocena" class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                        @for($i = 5; $i >= 1; $i--)<option value="{{ $i }}">{{ $i }} ⭐</option>@endfor
                    </select>
                </div>
                <div class="mb-3">
                    <label class="block text-sm text-gray-400 mb-1">Komentarz (opcjonalnie)</label>
                    <textarea name="komentarz" rows="2" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white"></textarea>
                </div>
                <button class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-4 py-2 rounded-lg text-sm transition">Dodaj opinię</button>
            </form>
        @endauth

        <div class="space-y-3">
            @forelse($opinions as $opinia)
                <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
                    <div class="flex justify-between items-center mb-1">
                        <span class="text-white font-medium">{{ $opinia->user->imie_nazwisko }}</span>
                        <span class="text-yellow-400">{{ str_repeat('⭐', $opinia->ocena) }}</span>
                    </div>
                    @if($opinia->komentarz)<p class="text-gray-400 text-sm">{{ $opinia->komentarz }}</p>@endif
                </div>
            @empty
                <p class="text-gray-500">Brak opinii. Bądź pierwszy!</p>
            @endforelse
        </div>
    </div>
@endsection
