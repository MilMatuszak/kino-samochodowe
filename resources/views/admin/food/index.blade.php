@extends('layouts.app')
@section('title', 'Panel zamówień')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-8">Zamówienia gastronomiczne</h1>

    <div class="space-y-3">
        @forelse($zamowienia as $z)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
                <div class="flex items-start justify-between mb-3">
                    <div>
                        <p class="text-white font-semibold">Zamówienie #{{ $z->id }}</p>
                        <p class="text-gray-400 text-sm">
                            {{ $z->user->imie_nazwisko }} ·
                            {{ \Carbon\Carbon::parse($z->czas_zlozenia)->format('d.m.Y H:i') }} ·
                            {{ number_format($z->suma, 2) }} zł
                        </p>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full
                @if($z->status === 'nowe') bg-yellow-900 text-yellow-300
                @elseif($z->status === 'przyjete') bg-blue-900 text-blue-300
                @elseif($z->status === 'w_realizacji') bg-purple-900 text-purple-300
                @else bg-gray-800 text-gray-400 @endif">
                {{ ucfirst(str_replace('_', ' ', $z->status)) }}
            </span>
                </div>

                {{-- Pozycje zamówienia --}}
                <div class="bg-gray-950 rounded-lg p-3 mb-3 space-y-1">
                    @foreach($z->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-300">{{ $item->foodProduct->nazwa }} × {{ $item->ilosc }}</span>
                            <span class="text-gray-400">{{ number_format($item->cena_jednostkowa * $item->ilosc, 2) }} zł</span>
                        </div>
                    @endforeach
                </div>

                {{-- Akcje zmiany statusu --}}
                <div class="flex flex-wrap gap-2">
                    @foreach(['przyjete' => 'Przyjmij', 'w_realizacji' => 'W realizację', 'dostarczone' => 'Dostarczone', 'anulowane' => 'Anuluj'] as $status => $label)
                        <form action="{{ route('panel.food.update', $z) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="{{ $status }}">
                            <button class="@if($status === 'anulowane') bg-red-900 hover:bg-red-800 text-red-200 @else bg-gray-800 hover:bg-gray-700 text-white @endif px-3 py-1.5 rounded-lg text-sm transition">
                                {{ $label }}
                            </button>
                        </form>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="text-center py-16 text-gray-500">
                <p class="text-4xl mb-3">🍿</p>
                <p>Brak aktywnych zamówień.</p>
            </div>
        @endforelse
    </div>
@endsection
