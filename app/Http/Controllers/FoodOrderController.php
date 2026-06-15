<?php

namespace App\Http\Controllers;

use App\Models\{FoodOrder, FoodProduct, OrderItem};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class FoodOrderController extends Controller
{
    public function menu()
    {
        $produkty = FoodProduct::dostepne()->get()->groupBy('kategoria');
        return view('food.menu', compact('produkty'));
    }

    public function store(Request $request)
    {
        // Odfiltruj produkty z ilością 0
        $produkty = collect($request->produkty ?? [])
            ->filter(fn($p) => (int)($p['ilosc'] ?? 0) > 0)
            ->values()
            ->all();

        if (empty($produkty)) {
            return back()->with('error', 'Wybierz przynajmniej jeden produkt.');
        }

        $request->merge(['produkty' => $produkty]);

        $request->validate([
            'produkty'         => 'required|array|min:1',
            'produkty.*.id'    => 'required|exists:food_products,id',
            'produkty.*.ilosc' => 'required|integer|min:1',
            'reservation_id'   => 'nullable|exists:reservations,id',
            'platnosc'         => 'required|in:online,przy_odbiorze',
        ]);

        $zamowienie = FoodOrder::create([
            'user_id'        => Auth::id(),
            'reservation_id' => $request->reservation_id,
            'czas_zlozenia'  => now(),
            'platnosc'       => $request->platnosc,
            'status'         => 'nowe',
        ]);

        foreach ($produkty as $item) {
            $produkt = FoodProduct::find($item['id']);
            OrderItem::create([
                'food_order_id'    => $zamowienie->id,
                'food_product_id'  => $produkt->id,
                'ilosc'            => $item['ilosc'],
                'cena_jednostkowa' => $produkt->cena,
            ]);
        }

        $zamowienie->load('items');
        $zamowienie->przeliczSume();

        NotificationService::wyslij(
            $zamowienie->user,
            'sms',
            'Zamówienie przyjęte',
            "Twoje zamówienie #{$zamowienie->id} na kwotę " . number_format($zamowienie->suma, 2) . " zł zostało przyjęte."
        );

        return redirect()->route('food.status', $zamowienie)->with('success', 'Zamówienie złożone!');
    }


    public function status(FoodOrder $order)
    {
        return view('food.status', compact('order'));
    }

    public function pracownikIndex()
    {
        $zamowienia = FoodOrder::whereIn('status', ['nowe', 'przyjete', 'w_realizacji'])
            ->with(['user', 'items.foodProduct'])
            ->latest()
            ->get();
        return view('admin.food.index', compact('zamowienia'));
    }

    public function updateStatus(Request $request, FoodOrder $order)
    {
        $request->validate(['status' => 'required|in:przyjete,w_realizacji,dostarczone,anulowane']);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Status zamówienia zaktualizowany.');
    }

    // Lista zamówień zalogowanego klienta
    public function mojeZamowienia()
    {
        $zamowienia = \App\Models\FoodOrder::where('user_id', auth()->id())
            ->with('items.foodProduct')
            ->latest()
            ->get();

        return view('food.moje', compact('zamowienia'));
    }
}
