@extends('layouts.app')
@section('title', 'Użytkownicy')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-yellow-400">Zarządzanie użytkownikami</h1>
        <a href="{{ route('admin.users.create') }}" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-4 py-2 rounded-lg transition">+ Dodaj użytkownika</a>
    </div>

    {{-- Statystyki ról --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-6">
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-3 text-center">
            <div class="text-2xl font-bold text-yellow-400">{{ $statystyki['wszyscy'] }}</div>
            <div class="text-gray-400 text-xs mt-1">Wszyscy</div>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-3 text-center">
            <div class="text-2xl font-bold text-white">{{ $statystyki['klient'] }}</div>
            <div class="text-gray-400 text-xs mt-1">Klienci</div>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-3 text-center">
            <div class="text-2xl font-bold text-white">{{ $statystyki['pracownik'] }}</div>
            <div class="text-gray-400 text-xs mt-1">Pracownicy</div>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-3 text-center">
            <div class="text-2xl font-bold text-white">{{ $statystyki['kierownik'] }}</div>
            <div class="text-gray-400 text-xs mt-1">Kierownicy</div>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-3 text-center">
            <div class="text-2xl font-bold text-white">{{ $statystyki['partner'] }}</div>
            <div class="text-gray-400 text-xs mt-1">Partnerzy</div>
        </div>
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-3 text-center">
            <div class="text-2xl font-bold text-white">{{ $statystyki['administrator'] }}</div>
            <div class="text-gray-400 text-xs mt-1">Administratorzy</div>
        </div>
    </div>

    {{-- Wyszukiwarka i filtr (AJAX) --}}
    <div class="flex flex-wrap gap-3 mb-6 items-center">
        <input type="text" id="szukaj" placeholder="Szukaj po imieniu lub e-mailu..."
               class="flex-1 min-w-[200px] bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:border-yellow-500 focus:outline-none">
        <select id="filtrRoli" class="bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
            <option value="">Wszystkie role</option>
            @foreach(['klient','pracownik','kierownik','partner','administrator'] as $r)
                <option value="{{ $r }}">{{ ucfirst($r) }}</option>
            @endforeach
        </select>
        <span id="ladowanie" class="text-gray-500 text-sm hidden">Ładowanie…</span>
    </div>

    {{-- Kontener listy — podmieniany przez AJAX --}}
    <div id="listaContainer">
        @include('admin.users._lista')
    </div>

    <script>
        const poleSzukaj = document.getElementById('szukaj');
        const poleRola   = document.getElementById('filtrRoli');
        const kontener   = document.getElementById('listaContainer');
        const ladowanie  = document.getElementById('ladowanie');
        let timer = null;

        function pobierz() {
            const params = new URLSearchParams({
                szukaj: poleSzukaj.value,
                rola:   poleRola.value,
            });

            ladowanie.classList.remove('hidden');

            fetch(`{{ route('admin.users') }}?${params.toString()}`, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(response => response.text())
                .then(html => {
                    kontener.innerHTML = html;
                    ladowanie.classList.add('hidden');
                })
                .catch(() => {
                    ladowanie.classList.add('hidden');
                });
        }

        // Debounce — czeka 250ms po ostatnim wpisaniu znaku
        function zaplanuj() {
            clearTimeout(timer);
            timer = setTimeout(pobierz, 250);
        }

        poleSzukaj.addEventListener('input', zaplanuj);
        poleRola.addEventListener('change', pobierz);
    </script>
@endsection
