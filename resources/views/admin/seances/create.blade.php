@extends('layouts.app')
@section('title', 'Dodaj seans')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-yellow-400 mb-6">Dodaj seans</h1>
        <form action="{{ route('admin.seances.store') }}" method="POST" class="bg-gray-900 border border-gray-800 rounded-xl p-6 space-y-4">
            @csrf
            <div>
                <label class="block text-sm text-gray-400 mb-1">Film</label>
                <select name="film_id" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                    @foreach($films as $film)
                        <option value="{{ $film->id }}">{{ $film->tytul }}</option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Data</label>
                    <input type="date" name="data" value="{{ old('data') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Godzina</label>
                    <input type="time" name="godzina_rozpoczecia" value="{{ old('godzina_rozpoczecia') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Ekran</label>
                    <input type="text" name="ekran_projekcyjny" value="{{ old('ekran_projekcyjny', 'Ekran główny') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                </div>
                <div>
                    <label class="block text-sm text-gray-400 mb-1">Cena biletu (zł)</label>
                    <input type="number" step="0.01" name="cena_biletu" value="{{ old('cena_biletu', '35.00') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                </div>
            </div>
            <div class="flex gap-3">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-6 py-2 rounded-lg transition">Zapisz</button>
                <a href="{{ route('admin.seances.index') }}" class="bg-gray-800 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition">Anuluj</a>
            </div>
        </form>
    </div>
@endsection
