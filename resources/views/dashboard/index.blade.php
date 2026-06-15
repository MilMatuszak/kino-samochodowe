@extends('layouts.app')
@section('title', 'Panel')

@section('content')
    @php $u = auth()->user(); @endphp

    <h1 class="text-3xl font-bold text-yellow-400 mb-1">Witaj, {{ $u->imie_nazwisko }}!</h1>
    <p class="text-gray-400 mb-8">Twoja rola: <span class="text-yellow-400">{{ ucfirst($u->rola) }}</span></p>

    {{-- ===================== KLIENT ===================== --}}
    @if($u->isKlient())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('films.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">🎬</div>
                <h2 class="font-bold text-white mb-1">Repertuar</h2>
                <p class="text-gray-400 text-sm">Przeglądaj filmy</p>
            </a>
            <a href="{{ route('seances.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">📅</div>
                <h2 class="font-bold text-white mb-1">Seanse</h2>
                <p class="text-gray-400 text-sm">Wszystkie zaplanowane seanse</p>
            </a>
            <a href="{{ route('reservations.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">🎟️</div>
                <h2 class="font-bold text-white mb-1">Moje rezerwacje</h2>
                <p class="text-gray-400 text-sm">Zarządzaj biletami</p>
            </a>
            <a href="{{ route('food.menu') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">🍿</div>
                <h2 class="font-bold text-white mb-1">Menu</h2>
                <p class="text-gray-400 text-sm">Zamów przekąski</p>
            </a>
            <a href="{{ route('food.moje') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">📋</div>
                <h2 class="font-bold text-white mb-1">Moje zamówienia</h2>
                <p class="text-gray-400 text-sm">Historia i status zamówień</p>
            </a>
        </div>
    @endif

    {{-- ===================== PRACOWNIK ===================== --}}
    @if($u->isPracownik())
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <a href="{{ route('panel.food.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">🍔</div>
                <h2 class="font-bold text-white mb-1">Zamówienia gastronomiczne</h2>
                <p class="text-gray-400 text-sm">Obsługuj i zmieniaj status zamówień</p>
            </a>
            <a href="{{ route('panel.parking.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">🅿️</div>
                <h2 class="font-bold text-white mb-1">Parking</h2>
                <p class="text-gray-400 text-sm">Optymalizacja i przydział miejsc</p>
            </a>
            <a href="{{ route('films.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">🎬</div>
                <h2 class="font-bold text-white mb-1">Repertuar</h2>
                <p class="text-gray-400 text-sm">Podgląd aktualnych seansów</p>
            </a>
        </div>
    @endif

    {{-- ===================== KIEROWNIK ===================== --}}
    @if($u->isKierownik())
        <h3 class="text-lg font-semibold text-white mb-3">Zarządzanie</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <a href="{{ route('admin.films.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">🎬</div>
                <h2 class="font-bold text-white mb-1">Filmy</h2>
                <p class="text-gray-400 text-sm">Zarządzaj repertuarem</p>
            </a>
            <a href="{{ route('admin.seances.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">📅</div>
                <h2 class="font-bold text-white mb-1">Seanse</h2>
                <p class="text-gray-400 text-sm">Harmonogram seansów</p>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">📊</div>
                <h2 class="font-bold text-white mb-1">Raporty</h2>
                <p class="text-gray-400 text-sm">Raporty sprzedaży</p>
            </a>
            <a href="{{ route('admin.reports.popularnosc') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">📈</div>
                <h2 class="font-bold text-white mb-1">Analiza filmów</h2>
                <p class="text-gray-400 text-sm">Popularność i przychody</p>
            </a>
            <a href="{{ route('admin.opinions.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">⭐</div>
                <h2 class="font-bold text-white mb-1">Moderacja opinii</h2>
                <p class="text-gray-400 text-sm">Zatwierdzaj i ukrywaj opinie</p>
            </a>
            <a href="{{ route('admin.notifications.index') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">🔔</div>
                <h2 class="font-bold text-white mb-1">Powiadomienia</h2>
                <p class="text-gray-400 text-sm">Dziennik powiadomień</p>
            </a>
        </div>
    @endif

    {{-- ===================== ADMINISTRATOR ===================== --}}
    @if($u->isAdmin())
        <h3 class="text-lg font-semibold text-white mb-3">Administracja</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <a href="{{ route('admin.users') }}" class="bg-gray-900 border border-gray-800 rounded-xl p-6 hover:border-yellow-500 transition">
                <div class="text-4xl mb-3">👥</div>
                <h2 class="font-bold text-white mb-1">Użytkownicy</h2>
                <p class="text-gray-400 text-sm">Konta, role, blokowanie</p>
            </a>
        </div>
    @endif

    {{-- ===================== PARTNER (planowana / mock) ===================== --}}
    @if($u->isPartner())
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-8 text-center">
            <div class="text-5xl mb-4">🤝</div>
            <h2 class="font-bold text-white text-xl mb-2">Panel partnera</h2>
            <p class="text-gray-400 max-w-md mx-auto">
                Funkcje dla partnerów zewnętrznych (dystrybutorzy filmów, firmy cateringowe)
                są w przygotowaniu i pojawią się w kolejnej wersji systemu.
            </p>
            <span class="inline-block mt-4 text-xs px-3 py-1 rounded-full bg-yellow-900 text-yellow-300">Moduł planowany</span>
        </div>
    @endif

@endsection
