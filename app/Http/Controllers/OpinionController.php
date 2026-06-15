<?php

namespace App\Http\Controllers;

use App\Models\{Opinion, Film};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OpinionController extends Controller
{
    public function store(Request $request, Film $film)
    {
        $request->validate([
            'ocena'     => 'required|integer|between:1,5',
            'komentarz' => 'nullable|string|max:1000',
        ]);

        $istnieje = Opinion::where('user_id', Auth::id())
            ->where('film_id', $film->id)->exists();

        if ($istnieje) {
            return back()->with('error', 'Już oceniłeś ten film.');
        }

        Opinion::create([
            'user_id'          => Auth::id(),
            'film_id'          => $film->id,
            'ocena'            => $request->ocena,
            'komentarz'        => $request->komentarz,
            'status_moderacji' => 'oczekujaca',
        ]);

        return back()->with('success', 'Dziękujemy za opinię! Zostanie opublikowana po moderacji.');
    }

    public function moderacjaIndex()
    {
        $opinie = Opinion::where('status_moderacji', 'oczekujaca')
            ->with(['user', 'film'])->latest()->get();
        return view('admin.opinions.index', compact('opinie'));
    }

    public function moderacjaUpdate(Request $request, Opinion $opinion)
    {
        $request->validate(['akcja' => 'required|in:opublikuj,ukryj']);
        $status = $request->akcja === 'opublikuj' ? 'opublikowana' : 'ukryta';
        $opinion->update(['status_moderacji' => $status]);
        return back()->with('success', 'Opinia zaktualizowana.');
    }
}
