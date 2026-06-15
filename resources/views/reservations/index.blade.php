@extends('layouts.app')
@section('title', 'Moje rezerwacje')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-8">Moje rezerwacje</h1>

    <div class="space-y-3">
        @forelse($reservations as $r)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-white font-semibold">{{ $r->seance->film->tytul }}</p>
                    <p class="text-gray-400 text-sm">
                        {{ \Carbon\Carbon::parse($r->seance->data)->format('d.m.Y') }} ·
                        {{ \Carbon\Carbon::parse($r->seance->godzina_rozpoczecia)->format('H:i') }} ·
                        Miejsce: {{ $r->parkingSpot->numer_miejsca ?? '—' }}
                    </p>
                    <span class="inline-block mt-1 text-xs px-2 py-0.5 rounded-full
                @if($r->status === 'potwierdzona') bg-green-900 text-green-300
                @elseif($r->status === 'oczekujaca') bg-yellow-900 text-yellow-300
                @elseif($r->status === 'anulowana') bg-red-900 text-red-300
                @else bg-gray-800 text-gray-400 @endif">
                {{ ucfirst($r->status) }}
            </span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('reservations.show', $r) }}" class="bg-gray-800 hover:bg-gray-700 text-white px-3 py-2 rounded-lg text-sm transition">Bilet</a>
                    @if($r->moznaAnulowac())
                        <form action="{{ route('reservations.cancel', $r) }}" method="POST" onsubmit="return confirm('Na pewno anulować?')">
                            @csrf
                            <button class="bg-red-900 hover:bg-red-800 text-red-200 px-3 py-2 rounded-lg text-sm transition">Anuluj</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500">Nie masz jeszcze żadnych rezerwacji.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $reservations->links() }}</div>
@endsection
