@extends('layouts.app')
@section('title', 'Raporty sprzedaży')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Raporty sprzedaży</h1>

    <form action="{{ route('admin.reports.generate') }}" method="POST" class="bg-gray-900 border border-gray-800 rounded-xl p-6 max-w-xl">
        @csrf
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm text-gray-400 mb-1">Data od</label>
                <input type="date" name="data_od" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm text-gray-400 mb-1">Data do</label>
                <input type="date" name="data_do" required class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-sm text-gray-400 mb-1">Format</label>
            <select name="format" class="w-full bg-gray-800 border border-gray-700 rounded-lg px-3 py-2 text-white">
                <option value="pdf">Podgląd na stronie</option>
                <option value="csv">Pobierz CSV</option>
            </select>
        </div>
        <button type="submit" class="bg-yellow-500 hover:bg-yellow-400 text-gray-900 font-semibold px-6 py-2 rounded-lg transition">Generuj raport</button>
    </form>
@endsection
