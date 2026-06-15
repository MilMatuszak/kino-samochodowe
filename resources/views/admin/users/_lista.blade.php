<div class="space-y-2">
    @forelse($users as $user)
        <div class="bg-gray-900 border border-gray-800 rounded-xl p-4 flex items-center justify-between">
            <div>
                <p class="text-white font-semibold">
                    {{ $user->imie_nazwisko }}
                    @if($user->id === auth()->id())
                        <span class="text-xs text-yellow-400">(to Ty)</span>
                    @endif
                </p>
                <p class="text-gray-400 text-sm">{{ $user->email }} · {{ ucfirst($user->rola) }}@if($user->telefon) · {{ $user->telefon }}@endif</p>
            </div>
            <div class="flex items-center gap-3">
            <span class="text-xs px-2 py-0.5 rounded-full @if($user->aktywny) bg-green-900 text-green-300 @else bg-red-900 text-red-300 @endif">
                {{ $user->aktywny ? 'Aktywny' : 'Zablokowany' }}
            </span>

                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.role', $user) }}" method="POST">
                        @csrf
                        <select name="rola" onchange="this.form.submit()" class="bg-gray-800 border border-gray-700 rounded-lg px-2 py-1 text-white text-sm">
                            @foreach(['klient','pracownik','kierownik','partner','administrator'] as $r)
                                <option value="{{ $r }}" @selected($user->rola === $r)>{{ ucfirst($r) }}</option>
                            @endforeach
                        </select>
                    </form>
                @else
                    <span class="text-gray-600 text-sm italic px-2">{{ ucfirst($user->rola) }}</span>
                @endif

                <a href="{{ route('admin.users.edit', $user) }}" class="bg-gray-800 hover:bg-gray-700 text-white px-3 py-1.5 rounded-lg text-sm transition">Edytuj</a>

                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.block', $user) }}" method="POST">
                        @csrf
                        <button class="@if($user->aktywny) bg-red-900 hover:bg-red-800 text-red-200 @else bg-green-900 hover:bg-green-800 text-green-200 @endif px-3 py-1.5 rounded-lg text-sm transition">
                            {{ $user->aktywny ? 'Zablokuj' : 'Odblokuj' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-gray-500 text-center py-8">Brak użytkowników spełniających kryteria.</p>
    @endforelse
</div>

<div class="mt-6">{{ $users->links() }}</div>
