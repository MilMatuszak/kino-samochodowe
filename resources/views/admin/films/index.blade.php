@extends('layouts.app')
@section('title', 'Panel — Filmy')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-yellow-400">Zarządzanie filmami</h1>
        <a href="{{ route('admin.films.create') }}" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-4 py-2 rounded-lg transition">+ Dodaj film</a>
    </div>


    <div class="space-y-2">
        @forelse($films as $film)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 flex items-center justify-between">
                <div>
                    <p class="text-white font-semibold">{{ $film->tytul }}</p>
                    <p class="text-gray-400 text-sm">{{ $film->gatunek }} · {{ $film->czas_trwania }} min · {{ $film->wiek_ograniczenie }}+</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.films.edit', $film) }}" class="bg-gray-800 hover:bg-gray-700 text-white px-3 py-2 rounded-lg text-sm transition">Edytuj</a>
                    <form action="{{ route('admin.films.destroy', $film) }}" method="POST" onsubmit="return confirm('Usunąć film?')">
                        @csrf @method('DELETE')
                        <button class="bg-red-900 hover:bg-red-800 text-red-200 px-3 py-2 rounded-lg text-sm transition">Usuń</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Brak filmów.</p>
        @endforelse
    </div>

    <div class="mt-6">{{ $films->links() }}</div>
@endsection
