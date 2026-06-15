@extends('layouts.app')
@section('title', 'Repertuar')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-8">Repertuar</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($films as $film)
            <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden hover:border-yellow-500 transition group">
                @if($film->plakat)
                    <img src="{{ asset('storage/' . $film->plakat) }}" alt="{{ $film->tytul }}" class="w-full h-48 object-cover">
                @else
                    <div class="w-full h-48 bg-gray-800 flex items-center justify-center text-5xl">🎬</div>
                @endif
                <div class="p-4">
                    <div class="flex items-start justify-between gap-2 mb-2">
                        <h2 class="font-bold text-lg text-white">{{ $film->tytul }}</h2>
                        <span class="bg-yellow-500 text-gray-900 text-xs font-bold px-2 py-0.5 rounded shrink-0">
                    {{ $film->wiek_ograniczenie === 0 ? 'B/o' : $film->wiek_ograniczenie . '+' }}
                </span>
                    </div>
                    <div class="flex gap-3 text-sm text-gray-400 mb-3">
                        <span>{{ $film->gatunek }}</span><span>·</span>
                        <span>{{ $film->czas_trwania }} min</span><span>·</span>
                        <span>⭐ {{ number_format($film->srednia_ocena(), 1) }}</span>
                    </div>
                    <p class="text-gray-400 text-sm mb-4 line-clamp-2">{{ $film->opis }}</p>
                    <a href="{{ route('films.show', $film) }}" class="block text-center bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold py-2 rounded-lg transition text-sm">Zobacz seanse →</a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center py-16 text-gray-500"><p class="text-4xl mb-3">🎬</p><p>Brak filmów w repertuarze.</p></div>
        @endforelse
    </div>
@endsection
