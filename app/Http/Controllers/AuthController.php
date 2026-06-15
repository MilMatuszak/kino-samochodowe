<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'haslo' => 'required|min:6',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->haslo, $user->haslo)) {
            return back()->withErrors(['email' => 'Nieprawidłowy email lub hasło.']);
        }

        if (!$user->aktywny) {
            return back()->withErrors(['email' => 'Konto zostało zablokowane.']);
        }

        Auth::login($user, $request->boolean('pamietaj'));
        return redirect()->route('dashboard');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'imie_nazwisko' => 'required|string|max:255',
            'email'         => 'required|email|unique:users',
            'haslo'         => 'required|min:8|confirmed',
            'telefon'       => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'imie_nazwisko' => $request->imie_nazwisko,
            'email'         => $request->email,
            'haslo'         => Hash::make($request->haslo),
            'telefon'       => $request->telefon,
            'rola'          => 'klient',
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Konto zostało utworzone!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        return redirect()->route('login');
    }
}
