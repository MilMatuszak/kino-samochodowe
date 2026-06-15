@extends('layouts.app')
@section('title', 'Dziennik powiadomień')

@section('content')
    <h1 class="text-3xl font-bold text-yellow-400 mb-6">Dziennik powiadomień</h1>

    <div class="bg-gray-900 border border-gray-800 rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-800 text-gray-300">
            <tr>
                <th class="text-left px-4 py-3">Kanał</th>
                <th class="text-left px-4 py-3">Odbiorca</th>
                <th class="text-left px-4 py-3">Temat</th>
                <th class="text-left px-4 py-3">Treść</th>
                <th class="text-left px-4 py-3">Data</th>
            </tr>
            </thead>
            <tbody>
            @forelse($powiadomienia as $pow)
                <tr class="border-t border-gray-800">
                    <td class="px-4 py-3">
                    <span class="text-xs px-2 py-0.5 rounded-full @if($pow->kanal === 'sms') bg-blue-900 text-blue-300 @else bg-purple-900 text-purple-300 @endif">
                        {{ strtoupper($pow->kanal) }}
                    </span>
                    </td>
                    <td class="px-4 py-3 text-gray-300">{{ $pow->odbiorca }}</td>
                    <td class="px-4 py-3 text-white">{{ $pow->temat }}</td>
                    <td class="px-4 py-3 text-gray-400">{{ Str::limit($pow->tresc, 60) }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $pow->created_at->format('d.m.Y H:i') }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-gray-500">Brak powiadomień.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $powiadomienia->links() }}</div>
@endsection
