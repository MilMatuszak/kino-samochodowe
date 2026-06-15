@extends('layouts.app')
@section('title', 'Analiza popularności filmów')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Analiza popularności filmów</h1>

    @if($filmy->isEmpty())
        <p class="text-gray-500">Brak danych do analizy.</p>
    @else
        {{-- Wykres --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mb-6">
            <h2 class="font-semibold text-white mb-4">Liczba rezerwacji według filmu</h2>
            <canvas id="wykresPopularnosci" height="100"></canvas>
        </div>

        {{-- Tabela --}}
        <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-gray-800 text-gray-300">
                <tr>
                    <th class="text-left px-4 py-3">#</th>
                    <th class="text-left px-4 py-3">Film</th>
                    <th class="text-right px-4 py-3">Rezerwacje</th>
                    <th class="text-right px-4 py-3">Przychód</th>
                    <th class="text-right px-4 py-3">Śr. ocena</th>
                </tr>
                </thead>
                <tbody>
                @foreach($filmy as $i => $f)
                    <tr class="border-t border-gray-800">
                        <td class="px-4 py-3 text-gray-500">{{ $i + 1 }}</td>
                        <td class="px-4 py-3 text-white">{{ $f['tytul'] }}</td>
                        <td class="px-4 py-3 text-right text-gray-300">{{ $f['rezerwacje'] }}</td>
                        <td class="px-4 py-3 text-right text-yellow-400">{{ number_format($f['przychod'], 2) }} zł</td>
                        <td class="px-4 py-3 text-right text-gray-300">⭐ {{ $f['srednia_ocen'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const dane = @json($filmy);
            if (dane.length > 0) {
                new Chart(document.getElementById('wykresPopularnosci'), {
                    type: 'bar',
                    data: {
                        labels: dane.map(f => f.tytul),
                        datasets: [{
                            label: 'Liczba rezerwacji',
                            data: dane.map(f => f.rezerwacje),
                            backgroundColor: '#eab308',
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        plugins: { legend: { labels: { color: '#d1d5db' } } },
                        scales: {
                            y: { beginAtZero: true, ticks: { color: '#9ca3af', stepSize: 1, precision: 0 }, grid: { color: '#1f2937' } },                            x: { ticks: { color: '#9ca3af' }, grid: { display: false } }
                        }
                    }
                });
            }
        });
    </script>
@endsection
