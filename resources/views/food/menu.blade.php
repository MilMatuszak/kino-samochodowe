@extends('layouts.app')
@section('title', 'Menu')

@section('content')
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-yellow-400 mb-8">Menu gastronomiczne</h1>

        <form action="{{ route('food.store') }}" method="POST" id="orderForm">
            @csrf

            @foreach($produkty as $kategoria => $items)
                <h2 class="text-xl font-bold text-white mb-3 mt-6 capitalize">{{ $kategoria }}</h2>
                <div class="space-y-2">
                    @foreach($items as $i => $produkt)
                        <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 flex items-center justify-between">
                            <div>
                                <p class="text-white font-medium">{{ $produkt->nazwa }}</p>
                                <p class="text-yellow-400 text-sm">{{ number_format($produkt->cena, 2) }} zł</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <input type="hidden" name="produkty[{{ $produkt->id }}][id]" value="{{ $produkt->id }}">
                                <label class="text-gray-400 text-sm">Ilość:</label>
                                <input type="number" name="produkty[{{ $produkt->id }}][ilosc]" value="0" min="0" max="20"
                                       data-cena="{{ $produkt->cena }}"
                                       class="qty w-16 bg-gray-800 border border-gray-700 rounded-lg px-2 py-1 text-white text-center">
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="bg-gray-900 border border-gray-800 rounded-xl p-6 mt-6">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-white font-semibold">Suma:</span>
                    <span id="suma" class="text-2xl font-bold text-yellow-400">0,00 zł</span>
                </div>
                <div class="mb-4">
                    <label class="block text-sm text-gray-400 mb-1">Płatność</label>
                    <select name="platnosc" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                        <option value="przy_odbiorze">Przy odbiorze</option>
                        <option value="online">Online</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-bold py-3 rounded-xl transition">Złóż zamówienie 🍿</button>
            </div>
        </form>
    </div>

    <script>
        function przeliczSume() {
            let suma = 0;
            document.querySelectorAll('.qty').forEach(input => {
                suma += (parseInt(input.value) || 0) * parseFloat(input.dataset.cena);
            });
            document.getElementById('suma').textContent = suma.toFixed(2).replace('.', ',') + ' zł';
        }
        document.querySelectorAll('.qty').forEach(input => input.addEventListener('input', przeliczSume));
    </script>
@endsection
