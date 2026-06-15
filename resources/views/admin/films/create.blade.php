@extends('layouts.app')
@section('title', 'Dodaj film')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-yellow-400 mb-6">Dodaj film</h1>

        <form action="{{ route('admin.films.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-400 mb-1">Tytuł</label>
                <input type="text" name="tytul" value="{{ old('tytul') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Opis</label>
                <textarea name="opis" rows="3" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">{{ old('opis') }}</textarea>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Czas (min)</label>
                    <input type="number" name="czas_trwania" value="{{ old('czas_trwania') }}" required min="1" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Wiek</label>
                    <select name="wiek_ograniczenie" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                        <option value="0">Bez ogr.</option><option value="7">7+</option><option value="12">12+</option><option value="16">16+</option><option value="18">18+</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Gatunek</label>
                    <input type="text" name="gatunek" value="{{ old('gatunek') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                </div>
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Plakat (opcjonalnie)</label>
                <input type="file" name="plakat" accept="image/*" class="w-full text-gray-400 text-sm">
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-6 py-2 rounded-lg transition">Zapisz</button>
                <a href="{{ route('admin.films.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition">Anuluj</a>
            </div>
        </form>
    </div>
@endsection
