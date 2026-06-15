<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('szukaj')) {
            $szukaj = $request->szukaj;
            $query->where(function ($q) use ($szukaj) {
                $q->where('imie_nazwisko', 'like', "%{$szukaj}%")
                    ->orWhere('email', 'like', "%{$szukaj}%");
            });
        }

        if ($request->filled('rola')) {
            $query->where('rola', $request->rola);
        }

        $users = $query->latest()->paginate(20)->withQueryString();

        // Żądanie AJAX — zwracamy tylko fragment z listą
        if ($request->ajax()) {
            return view('admin.users._lista', compact('users'));
        }

        $statystyki = [
            'wszyscy'       => User::count(),
            'klient'        => User::where('rola', 'klient')->count(),
            'pracownik'     => User::where('rola', 'pracownik')->count(),
            'kierownik'     => User::where('rola', 'kierownik')->count(),
            'partner'       => User::where('rola', 'partner')->count(),
            'administrator' => User::where('rola', 'administrator')->count(),
        ];

        return view('admin.users.index', compact('users', 'statystyki'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'imie_nazwisko' => 'required|string|max:255',
            'email'         => 'required|email|unique:users',
            'haslo'         => 'required|min:8|confirmed',
            'rola'          => 'required|in:klient,pracownik,kierownik,partner,administrator',
            'telefon'       => 'nullable|string|max:20',
        ]);

        User::create([
            'imie_nazwisko' => $request->imie_nazwisko,
            'email'         => $request->email,
            'haslo'         => Hash::make($request->haslo),
            'rola'          => $request->rola,
            'telefon'       => $request->telefon,
        ]);

        return redirect()->route('admin.users')->with('success', 'Użytkownik utworzony.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'imie_nazwisko' => 'required|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'telefon'       => 'nullable|string|max:20',
            'haslo'         => 'nullable|min:8|confirmed',
            ]);

        $dane = [
            'imie_nazwisko' => $request->imie_nazwisko,
            'email'         => $request->email,
            'telefon'       => $request->telefon,
        ];

        if ($request->filled('haslo')) {
            $dane['haslo'] = Hash::make($request->haslo);
        }

        $user->update($dane);

        return redirect()->route('admin.users')->with('success', 'Dane użytkownika zaktualizowane.');
    }

    public function toggleBlock(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Nie możesz zablokować własnego konta.');
        }

        $user->update(['aktywny' => !$user->aktywny]);
        $komunikat = $user->aktywny ? 'Konto odblokowane.' : 'Konto zablokowane.';
        return back()->with('success', $komunikat);
    }

    public function updateRole(Request $request, User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Nie możesz zmienić własnej roli.');
        }

        $request->validate(['rola' => 'required|in:klient,pracownik,kierownik,partner,administrator']);
        $user->update(['rola' => $request->rola]);
        return back()->with('success', 'Rola zaktualizowana.');
    }
}
