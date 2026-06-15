@extends('layouts.app')
@section('title', 'Optymalizacja parkingu')

@section('content')
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('panel.parking.index') }}" class="text-gray-400 hover:text-yellow-400 text-sm">← Powrót do listy seansów</a>

        <h1 class="text-2xl font-bold text-yellow-400 mt-3 mb-2">Optymalizacja rozmieszczenia pojazdów</h1>
        <p class="text-gray-400 mb-6">
            {{ $seance->film->tytul }} ·
            {{ \Carbon\Carbon::parse($seance->data)->format('d.m.Y') }} ·
            {{ \Carbon\Carbon::parse($seance->godzina_rozpoczecia)->format('H:i') }}
        </p>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
                <div class="text-3xl font-bold text-yellow-400">{{ $statystyki['przydzielono'] }}</div>
                <div class="text-gray-400 text-sm mt-1">przydzielonych pojazdów</div>
            </div>
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 text-center">
                <div class="text-3xl font-bold text-yellow-400">{{ $statystyki['wykorzystanie'] }}%</div>
                <div class="text-gray-400 text-sm mt-1">wykorzystania parkingu</div>
            </div>
        </div>

        @if(count($przydzialy) > 0)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-4">
                <h2 class="font-semibold text-white mb-1">Proponowany układ</h2>
                <p class="text-gray-500 text-sm mb-4">Algorytm umieszcza większe pojazdy na tylnych rzędach, aby nie zasłaniały ekranu mniejszym autom.</p>

                <div class="bg-gray-950 rounded-lg p-3 space-y-1">
                    @foreach($przydzialy as $przydzial)
                        <div class="flex items-center justify-between text-sm py-1.5 border-b border-gray-800 last:border-0">
                            <span class="text-gray-300">{{ $przydzial['klient'] }}</span>
                            <span class="text-gray-500">{{ $przydzial['pojazd'] }}</span>
                            <span class="font-mono text-yellow-400 bg-yellow-900/20 px-2 py-0.5 rounded">{{ $przydzial['miejsce'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <form action="{{ route('panel.parking.zatwierdz', $seance) }}" method="POST">
                @csrf
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-bold py-3 rounded-xl transition">
                    Zatwierdź proponowany układ ✓
                </button>
            </form>
        @else
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 text-center text-gray-500">
                <p class="text-4xl mb-3">🅿️</p>
                <p>Brak rezerwacji do optymalizacji dla tego seansu.</p>
                <p class="text-sm mt-1">Optymalizacja będzie możliwa, gdy pojawią się rezerwacje.</p>
            </div>
        @endif
    </div>
@endsection
