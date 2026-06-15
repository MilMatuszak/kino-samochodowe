@extends('layouts.app')
@section('title', 'Status zamówienia')

@section('content')
    <div class="max-w-md mx-auto">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 text-center">
            <div class="text-5xl mb-4">🍿</div>
            <h1 class="text-2xl font-bold text-yellow-400 mb-2">Zamówienie #{{ $order->id }}</h1>
            <span class="inline-block text-sm px-3 py-1 rounded-full mb-4
            @if($order->status === 'dostarczone') bg-green-900 text-green-300
            @elseif($order->status === 'nowe') bg-yellow-900 text-yellow-300
            @else bg-blue-900 text-blue-300 @endif">
            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
        </span>

            <div class="space-y-2 text-left border-t border-gray-800 pt-4 mt-2">
                @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-400">{{ $item->foodProduct->nazwa }} × {{ $item->ilosc }}</span>
                        <span class="text-white">{{ number_format($item->cena_jednostkowa * $item->ilosc, 2) }} zł</span>
                    </div>
                @endforeach
                <div class="flex justify-between font-bold text-base border-t border-gray-800 pt-2 mt-2">
                    <span class="text-gray-300">Razem</span>
                    <span class="text-yellow-400">{{ number_format($order->suma, 2) }} zł</span>
                </div>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" class="block text-center text-gray-400 hover:text-yellow-400 text-sm mt-4">← Powrót</a>
    </div>
@endsection
