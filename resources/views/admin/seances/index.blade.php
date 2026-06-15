@extends('layouts.app')
@section('title', 'Panel — Seanse')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-yellow-400">Zarządzanie seansami</h1>
        <a href="{{ route('admin.seances.create') }}" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-4 py-2 rounded-lg transition">+ Dodaj seans</a>
    </div>

    <div class="space-y-2">
        @forelse($seances as $seance)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-white font-semibold">{{ $seance->film->tytul }}</p>
                    <p class="text-gray-400 text-sm">
                        {{ \Carbon\Carbon::parse($seance->data)->format('d.m.Y') }} ·
                        {{ \Carbon\Carbon::parse($seance->godzina_rozpoczecia)->format('H:i') }} ·
                        {{ $seance->ekran_projekcyjny }} ·
                        @php $st = $seance->statusWyswietlany(); @endphp
                        <span class="@if($st === 'Odwołany') text-red-400 @elseif($st === 'Zakończony') text-gray-500 @elseif($st === 'W trakcie') text-green-400 @else text-blue-400 @endif">{{ $st }}</span>
                    </p>
                </div>
                @if(in_array($seance->statusWyswietlany(), ['Zaplanowany', 'W trakcie']))
                    <form action="{{ route('admin.seances.destroy', $seance) }}" method="POST" onsubmit="return confirm('Odwołać seans?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-900 hover:bg-red-800 text-red-200 px-3 py-2 rounded-lg text-sm transition">Odwołaj</button>
                    </form>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Brak seansów.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $seances->links() }}</div>
@endsection
