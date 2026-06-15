@extends('layouts.app')
@section('title', 'Dodaj użytkownika')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-yellow-400 mb-6">Dodaj użytkownika</h1>

        <form action="{{ route('admin.users.store') }}" method="POST" class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-400 mb-1">Imię i nazwisko</label>
                <input type="text" name="imie_nazwisko" value="{{ old('imie_nazwisko') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Hasło (min. 8 znaków)</label>
                    <input type="password" name="haslo" required minlength="8" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Powtórz hasło</label>
                    <input type="password" name="haslo_confirmation" required minlength="8" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Rola</label>
                    <select name="rola" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                        @foreach(['klient','pracownik','kierownik','partner','administrator'] as $r)
                            <option value="{{ $r }}">{{ ucfirst($r) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Telefon (opcjonalnie)</label>
                <input type="tel" name="telefon" value="{{ old('telefon') }}" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-6 py-2 rounded-lg transition">Zapisz</button>
                <a href="{{ route('admin.users') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition">Anuluj</a>
            </div>
        </form>
    </div>
@endsection
