@extends('layouts.app')
@section('title', 'Parking — optymalizacja')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-2">Optymalizacja parkingu</h1>
    <p class="text-gray-400 mb-6">Wybierz seans, aby przydzielić miejsca parkingowe według gabarytów pojazdów.</p>

    <div class="space-y-2">
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
                <a href="{{ route('panel.parking.optymalizacja', $seance) }}" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-4 py-2 rounded-lg text-sm transition">Optymalizuj parking 🅿️</a>
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">Brak aktywnych seansów.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $seances->links() }}</div>
@endsection
