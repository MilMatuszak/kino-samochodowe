@extends('layouts.app')
@section('title', 'Rejestracja')

@section('content')
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8">
            <h1 class="text-2xl font-bold text-yellow-400 mb-6 text-center">Załóż konto</h1>
            <form action="{{ route('register') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Imię i nazwisko</label>
                    <input type="text" name="imie_nazwisko" value="{{ old('imie_nazwisko') }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Telefon (opcjonalnie)</label>
                    <input type="tel" name="telefon" value="{{ old('telefon') }}"
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Hasło (min. 8 znaków)</label>
                    <input type="password" name="haslo" required minlength="8"
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Potwierdź hasło</label>
                    <input type="password" name="haslo_confirmation" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:outline-none">
                </div>
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold py-2.5 rounded-lg transition">Zarejestruj się</button>
            </form>
            <p class="text-center text-gray-500 text-sm mt-4">Masz już konto? <a href="{{ route('login') }}" class="text-yellow-400 hover:underline">Zaloguj się</a></p>
        </div>
    </div>
@endsection
