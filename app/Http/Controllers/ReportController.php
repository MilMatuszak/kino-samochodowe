<?php

namespace App\Http\Controllers;

use App\Models\Seance;
use App\Models\FoodOrder;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'data_od' => 'required|date',
            'data_do' => 'required|date|after_or_equal:data_od',
            'format'  => 'required|in:pdf,csv',
        ]);

        $seances = Seance::whereBetween('data', [$request->data_od, $request->data_do])
            ->with(['film', 'reservations.ticket'])
            ->get();

        $raport = $seances->map(function ($s) {
            $przychod = $s->reservations
                ->whereIn('status', ['potwierdzona', 'zrealizowana'])
                ->sum(fn($r) => $r->ticket?->cena ?? 0);
            return [
                'film'       => $s->film->tytul,
                'data'       => $s->data,
                'godzina'    => $s->godzina_rozpoczecia,
                'rezerwacje' => $s->reservations->count(),
                'przychod'   => $przychod,
            ];
        });

        // Przychód z biletów
        $przychodBilety = $raport->sum('przychod');

        // Zamówienia gastronomiczne w tym samym okresie (bez anulowanych)
        $zamowienia = FoodOrder::whereDate('czas_zlozenia', '>=', $request->data_od)
            ->whereDate('czas_zlozenia', '<=', $request->data_do)
            ->where('status', '!=', 'anulowane')
            ->get();

        $gastronomia = [
            'liczba'   => $zamowienia->count(),
            'przychod' => $zamowienia->sum('suma'),
        ];

        $przychodCalkowity = $przychodBilety + $gastronomia['przychod'];

        if ($request->format === 'csv') {
            return $this->exportCsv($raport, $request->data_od, $request->data_do, $gastronomia, $przychodBilety, $przychodCalkowity);
        }

        return view('admin.reports.show', compact('raport', 'request', 'gastronomia', 'przychodBilety', 'przychodCalkowity'));
    }

    private function exportCsv($raport, $od, $do, $gastronomia, $przychodBilety, $przychodCalkowity)
    {
        $filename = "raport_{$od}_{$do}.csv";
        $headers  = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($raport, $gastronomia, $przychodBilety, $przychodCalkowity) {
            $f = fopen('php://output', 'w');
            fputs($f, "\xEF\xBB\xBF");
            fputcsv($f, ['Film', 'Data', 'Godzina', 'Rezerwacje', 'Przychód (zł)'], ';');
            foreach ($raport as $row) {
                fputcsv($f, array_values($row), ';');
            }
            // Podsumowanie
            fputcsv($f, [], ';');
            fputcsv($f, ['Przychód z biletów', '', '', '', $przychodBilety], ';');
            fputcsv($f, ['Zamówienia gastronomiczne', $gastronomia['liczba'], '', '', $gastronomia['przychod']], ';');
            fputcsv($f, ['PRZYCHÓD CAŁKOWITY', '', '', '', $przychodCalkowity], ';');
            fclose($f);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function popularnosc()
    {
        $filmy = \App\Models\Film::withCount(['seances'])
            ->with('seances.reservations')
            ->get()
            ->map(function ($film) {
                $rezerwacje = $film->seances->sum(fn($s) => $s->reservations->count());
                $przychod = $film->seances->sum(function ($s) {
                    return $s->reservations
                        ->whereIn('status', ['potwierdzona', 'zrealizowana'])
                        ->sum(fn($r) => $r->ticket?->cena ?? 0);
                });
                return [
                    'tytul'        => $film->tytul,
                    'rezerwacje'   => $rezerwacje,
                    'przychod'     => $przychod,
                    'srednia_ocen' => round($film->srednia_ocena(), 1),
                ];
            })
            ->sortByDesc('rezerwacje')
            ->values();

        return view('admin.reports.popularnosc', compact('filmy'));
    }
}
