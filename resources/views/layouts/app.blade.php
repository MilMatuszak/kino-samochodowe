<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kino Samochodowe')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-gray-100 min-h-screen flex flex-col">

<nav class="bg-gray-900 border-b border-yellow-500 shadow-lg">
    <div class="max-w-7xl mx-auto px-4 flex items-center justify-between h-16">
        @auth
            <a href="{{ route('dashboard') }}" class="text-yellow-400 font-bold text-xl tracking-wide">🎬 Driven Cinema</a>
        @else
            <a href="{{ route('home') }}" class="text-yellow-400 font-bold text-xl tracking-wide">🎬 DriveIn Cinema</a>
        @endauth

        <div class="flex items-center gap-6 text-sm">
            @auth
                <a href="{{ route('dashboard') }}" class="hover:text-yellow-400 transition">Panel główny</a>
                <span class="text-gray-400">{{ auth()->user()->imie_nazwisko }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button class="text-red-400 hover:text-red-300 transition">Wyloguj</button>
                </form>
            @else
                <a href="{{ route('films.index') }}" class="hover:text-yellow-400 transition">Repertuar</a>
                <a href="{{ route('seances.index') }}" class="hover:text-yellow-400 transition">Seanse</a>
                <a href="{{ route('login') }}" class="hover:text-yellow-400 transition">Zaloguj</a>
                <a href="{{ route('register') }}" class="bg-yellow-500 text-gray-900 px-4 py-1.5 rounded-full font-medium hover:bg-yellow-400 transition">Zarejestruj</a>
            @endauth
        </div>
    </div>
</nav>

<div class="max-w-7xl mx-auto w-full px-4 pt-4">
    @if(session('success'))
        <div class="bg-green-900 border border-green-500 text-green-200 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-red-900 border border-red-500 text-red-200 px-4 py-3 rounded mb-4">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="bg-red-900 border border-red-500 text-red-200 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif
</div>

<main class="flex-1 max-w-7xl mx-auto w-full px-4 py-6">
    @yield('content')
</main>

<footer class="bg-gray-900 border-t border-gray-800 text-center text-gray-500 text-sm py-4">
    &copy; {{ date('Y') }} DriveIn Cinema System
</footer>
</body>
</html>
