@extends('layouts.app')
@section('title', 'Moderacja opinii')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Moderacja opinii</h1>

    <div class="space-y-3">
        @forelse($opinie as $opinia)
            <div class="bg-gray-900 border border-gray-800 rounded-xl p-4">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <p class="text-white font-medium">{{ $opinia->user->imie_nazwisko }} <span class="text-gray-500 text-sm">o filmie "{{ $opinia->film->tytul }}"</span></p>
                        <span class="text-yellow-400">{{ str_repeat('⭐', $opinia->ocena) }}</span>
                    </div>
                </div>
                @if($opinia->komentarz)<p class="text-gray-400 text-sm mb-3">{{ $opinia->komentarz }}</p>@endif
                <div class="flex gap-2">
                    <form action="{{ route('admin.opinions.update', $opinia) }}" method="POST">
                        @csrf
                        <input type="hidden" name="akcja" value="opublikuj">
                        <button class="bg-green-900 hover:bg-green-800 text-green-200 px-3 py-1.5 rounded-lg text-sm transition">Opublikuj</button>
                    </form>
                    <form action="{{ route('admin.opinions.update', $opinia) }}" method="POST">
                        @csrf
                        <input type="hidden" name="akcja" value="ukryj">
                        <button class="bg-red-900 hover:bg-red-800 text-red-200 px-3 py-1.5 rounded-lg text-sm transition">Ukryj</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="text-gray-500">Brak opinii do moderacji.</p>
        @endforelse
    </div>
@endsection
