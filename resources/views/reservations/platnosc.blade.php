@extends('layouts.app')
@section('title', 'Płatność')

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-bold text-yellow-400 mb-2">Płatność</h1>
        <p class="text-gray-400 mb-6">
            {{ $reservation->seance->film->tytul }} ·
            {{ \Carbon\Carbon::parse($reservation->seance->data)->format('d.m.Y') }} ·
            miejsce {{ $reservation->parkingSpot->numer_miejsca ?? '—' }}
        </p>

        <div class="bg-gray-900 border border-gray-800 rounded-xl p-6">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-800">
                <span class="text-gray-400">Do zapłaty</span>
                <span class="text-2xl font-bold text-yellow-400">{{ number_format($reservation->ticket->cena ?? 0, 2) }} zł</span>
            </div>

            <form action="{{ route('reservations.zaplac', $reservation) }}" method="POST" id="payForm">
                @csrf
                <label class="block text-sm text-gray-400 mb-2">Wybierz metodę płatności</label>
                <div class="space-y-2 mb-6">
                    @foreach(['karta' => '💳 Karta płatnicza', 'blik' => '📱 BLIK', 'przelew' => '🏦 Przelew online'] as $val => $label)
                        <label class="cursor-pointer block">
                            <input type="radio" name="metoda" value="{{ $val }}" class="sr-only peer" required>
                            <div class="border-2 border-gray-700 rounded-lg px-4 py-3 text-gray-300 peer-checked:border-yellow-400 peer-checked:bg-yellow-900/20 peer-checked:text-yellow-300 transition">
                                {{ $label }}
                            </div>
                        </label>
                    @endforeach
                </div>

                <button type="submit" id="payBtn" class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-bold py-3 rounded-xl transition">
                    Zapłać {{ number_format($reservation->ticket->cena ?? 0, 2) }} zł
                </button>
            </form>

            <p class="text-center text-xs text-gray-600 mt-4">
                🔒 Symulacja płatności (środowisko testowe)
            </p>
        </div>

        <a href="{{ route('reservations.show', $reservation) }}" class="block text-center text-gray-400 hover:text-yellow-400 text-sm mt-4">← Wróć do biletu</a>
    </div>

    <script>
        document.getElementById('payForm').addEventListener('submit', function() {
            const btn = document.getElementById('payBtn');
            btn.textContent = 'Przetwarzanie płatności...';
            btn.disabled = true;
            btn.classList.add('opacity-60');
        });
    </script>
@endsection
