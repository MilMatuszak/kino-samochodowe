@extends('layouts.app')
@section('title', 'Edycja użytkownika')

@section('content')
    <div class="max-w-2xl mx-auto">
        <a href="{{ route('admin.users') }}" class="text-gray-400 hover:text-yellow-400 text-sm">← Powrót do listy</a>
        <h1 class="text-2xl font-bold text-yellow-400 mt-3 mb-6">Edycja użytkownika</h1>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm text-gray-400 mb-1">Imię i nazwisko</label>
                <input type="text" name="imie_nazwisko" value="{{ old('imie_nazwisko', $user->imie_nazwisko) }}" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:border-yellow-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">E-mail</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:border-yellow-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Telefon (opcjonalnie)</label>
                <input type="tel" name="telefon" value="{{ old('telefon', $user->telefon) }}"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:border-yellow-500 focus:outline-none">
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Nowe hasło</label>
                <input type="password" name="haslo" minlength="8"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:border-yellow-500 focus:outline-none">
                <p class="text-gray-500 text-xs mt-1">Zostaw puste, aby nie zmieniać hasła.</p>
            </div>

            <div>
                <label class="block text-sm text-gray-400 mb-1">Powtórz nowe hasło</label>
                <input type="password" name="haslo_confirmation" minlength="8"
                       class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white focus:border-yellow-500 focus:outline-none">
            </div>

            <div class="bg-gray-950 rounded-lg p-3 text-sm text-gray-400">
                Aktualna rola: <span class="text-white">{{ ucfirst($user->rola) }}</span>
                <span class="text-gray-600">· rolę zmieniasz na liście użytkowników</span>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-6 py-2 rounded-lg transition">Zapisz zmiany</button>
                <a href="{{ route('admin.users') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition">Anuluj</a>
            </div>
        </form>
    </div>
@endsection
