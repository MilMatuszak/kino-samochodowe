@extends('layouts.app')
@section('title', 'Logowanie')

@section('content')
    <div class="max-w-md mx-auto mt-10">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl p-8">
            <h1 class="text-2xl font-bold text-yellow-400 mb-6 text-center">Zaloguj się</h1>
            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:outline-none">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Hasło</label>
                    <input type="password" name="haslo" required
                           class="w-full bg-gray-800 border border-gray-700 rounded-lg px-4 py-2.5 text-white focus:border-yellow-500 focus:outline-none">
                </div>
                <div class="flex items-center gap-2">
                    <input type="checkbox" name="pamietaj" id="pamietaj" class="accent-yellow-500">
                    <label for="pamietaj" class="text-sm text-gray-400">Pamiętaj mnie</label>
                </div>
                <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold py-2.5 rounded-lg transition">Zaloguj się</button>
            </form>
            <p class="text-center text-gray-500 text-sm mt-4">Nie masz konta? <a href="{{ route('register') }}" class="text-yellow-400 hover:underline">Zarejestruj się</a></p>
        </div>
    </div>
@endsection
