<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilmController extends Controller
{
    public function index()
    {
        $films = Film::aktywne()->withCount('seances')->get();
        return view('films.index', compact('films'));
    }

    public function show(Film $film)
    {
        $seances  = $film->seances()->nadchodzace()->get();
        $opinions = $film->opinions()->opublikowane()->with('user')->latest()->get();
        return view('films.show', compact('film', 'seances', 'opinions'));
    }

    public function adminIndex()
    {
        $films = Film::latest()->paginate(15);
        return view('admin.films.index', compact('films'));
    }

    public function create()
    {
        return view('admin.films.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'tytul'             => 'required|string|max:255',
            'opis'              => 'required|string',
            'czas_trwania'      => 'required|integer|min:1',
            'wiek_ograniczenie' => 'required|integer|in:0,7,12,16,18',
            'gatunek'           => 'required|string|max:100',
            'plakat'            => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('plakat')) {
            $data['plakat'] = $request->file('plakat')->store('plakaty', 'public');
        }

        Film::create($data);
        return redirect()->route('admin.films.index')->with('success', 'Film dodany pomyślnie.');
    }

    public function edit(Film $film)
    {
        return view('admin.films.edit', compact('film'));
    }

    public function update(Request $request, Film $film)
    {
        $data = $request->validate([
            'tytul'             => 'required|string|max:255',
            'opis'              => 'required|string',
            'czas_trwania'      => 'required|integer|min:1',
            'wiek_ograniczenie' => 'required|integer|in:0,7,12,16,18',
            'gatunek'           => 'required|string|max:100',
            'plakat'            => 'nullable|image|max:2048',
            'aktywny'           => 'boolean',
        ]);

        if ($request->hasFile('plakat')) {
            if ($film->plakat) Storage::disk('public')->delete($film->plakat);
            $data['plakat'] = $request->file('plakat')->store('plakaty', 'public');
        }

        $film->update($data);
        return redirect()->route('admin.films.index')->with('success', 'Film zaktualizowany.');
    }

    public function destroy(Film $film)
    {
        if ($film->plakat) Storage::disk('public')->delete($film->plakat);
        $film->delete();
        return redirect()->route('admin.films.index')->with('success', 'Film usunięty.');
    }
}
