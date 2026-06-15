@extends('layouts.app')
@section('title', 'Wynik raportu')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-2">Raport sprzedaży</h1>
    <p class="text-gray-400 mb-6">{{ $request->data_od }} — {{ $request->data_do }}</p>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden mb-6">
        <table class="w-full text-sm">
            <thead class="bg-gray-800 text-gray-300">
            <tr>
                <th class="text-left px-4 py-3">Film</th>
                <th class="text-left px-4 py-3">Data</th>
                <th class="text-left px-4 py-3">Godzina</th>
                <th class="text-right px-4 py-3">Rezerwacje</th>
                <th class="text-right px-4 py-3">Przychód</th>
            </tr>
            </thead>
            <tbody>
            @forelse($raport as $row)
                <tr class="border-t border-gray-800">
                    <td class="px-4 py-3 text-white">{{ $row['film'] }}</td>
                    <td class="px-4 py-3 text-gray-400">{{ \Carbon\Carbon::parse($row['data'])->format('d.m.Y') }}</td>
                    <td class="px-4 py-3 text-gray-400">{{ \Carbon\Carbon::parse($row['godzina'])->format('H:i') }}</td>
                    <td class="px-4 py-3 text-right text-gray-300">{{ $row['rezerwacje'] }}</td>
                    <td class="px-4 py-3 text-right text-yellow-400">{{ number_format($row['przychod'], 2) }} zł</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Brak seansów w tym okresie.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    {{-- Podsumowanie przychodów --}}
    <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 max-w-md ml-auto">
        <h2 class="font-semibold text-white mb-4">Podsumowanie przychodów</h2>

        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-400">🎟️ Bilety</span>
                <span class="text-gray-200">{{ number_format($przychodBilety, 2) }} zł</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-400">🍿 Gastronomia <span class="text-gray-600">({{ $gastronomia['liczba'] }} zam.)</span></span>
                <span class="text-gray-200">{{ number_format($gastronomia['przychod'], 2) }} zł</span>
            </div>
            <div class="flex justify-between pt-3 mt-2 border-t border-gray-700">
                <span class="text-white font-semibold">Przychód całkowity</span>
                <span class="text-yellow-400 font-bold text-lg">{{ number_format($przychodCalkowity, 2) }} zł</span>
            </div>
        </div>
    </div>

    <a href="{{ route('admin.reports.index') }}" class="inline-block text-gray-400 hover:text-yellow-400 text-sm mt-4">← Powrót do raportów</a>
@endsection
