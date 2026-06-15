@extends('layouts.app')
@section('title', 'Seanse')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-8">Nadchodzące seanse</h1>

    <div class="space-y-3">
        @forelse($seances as $seance)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-white font-semibold">{{ $seance->film->tytul }}</p>
                    <p class="text-gray-400 text-sm">
                        {{ \Carbon\Carbon::parse($seance->data)->format('d.m.Y') }} ·
                        {{ \Carbon\Carbon::parse($seance->godzina_rozpoczecia)->format('H:i') }} ·
                        {{ $seance->ekran_projekcyjny }}
                    </p>
                </div>
                @auth
                    <a href="{{ route('reservations.create', $seance) }}" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-4 py-2 rounded-lg text-sm transition">Rezerwuj</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-400 text-sm hover:text-yellow-400">Zaloguj</a>
                @endauth
            </div>
        @empty
            <p class="text-gray-500">Brak nadchodzących seansów.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $seances->links() }}</div>
@endsection
