<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, FilmController, SeanceController,
    ReservationController, FoodOrderController, OpinionController,
    ReportController, AdminController,
};

// Publiczne
Route::get('/', fn() => redirect()->route('films.index'))->name('home');
Route::get('/repertuar',   [FilmController::class, 'index'])->name('films.index');
Route::get('/film/{film}', [FilmController::class, 'show'])->name('films.show');
Route::get('/seanse',      [SeanceController::class, 'index'])->name('seances.index');

// Autoryzacja
Route::middleware('guest')->group(function () {
    Route::get('/logowanie',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/logowanie',  [AuthController::class, 'login']);
    Route::get('/rejestracja', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/rejestracja',[AuthController::class, 'register']);
});
Route::post('/wylogowanie', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Zalogowany klient
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('dashboard.index'))->name('dashboard');

    Route::get('/seans/{seance}/rezerwuj',  [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/seans/{seance}/rezerwuj', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/moje-rezerwacje',          [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/rezerwacja/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/rezerwacja/{reservation}/anuluj', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::get('/rezerwacja/{reservation}/platnosc',  [ReservationController::class, 'platnosc'])->name('reservations.platnosc');
    Route::post('/rezerwacja/{reservation}/platnosc', [ReservationController::class, 'zaplac'])->name('reservations.zaplac');

    Route::get('/menu',                      [FoodOrderController::class, 'menu'])->name('food.menu');
    Route::post('/zamowienie',               [FoodOrderController::class, 'store'])->name('food.store');
    Route::get('/zamowienie/{order}/status', [FoodOrderController::class, 'status'])->name('food.status');
    Route::get('/moje-zamowienia',           [FoodOrderController::class, 'mojeZamowienia'])->name('food.moje');

    Route::post('/film/{film}/opinia', [OpinionController::class, 'store'])->name('opinions.store');
});

// Pracownik (obsługa operacyjna: gastronomia + parking)
Route::middleware(['auth', 'rola:pracownik'])->prefix('panel')->name('panel.')->group(function () {
    Route::get('/zamowienia',                 [FoodOrderController::class, 'pracownikIndex'])->name('food.index');
    Route::post('/zamowienie/{order}/status', [FoodOrderController::class, 'updateStatus'])->name('food.update');

    Route::get('/parking',                        [SeanceController::class, 'parkingIndex'])->name('parking.index');
    Route::get('/parking/{seance}/optymalizacja', [SeanceController::class, 'optymalizacja'])->name('parking.optymalizacja');
    Route::post('/parking/{seance}/optymalizacja',[SeanceController::class, 'zatwierdzOptymalizacje'])->name('parking.zatwierdz');
});

// Kierownik (zarządzanie biznesowe)
Route::middleware(['auth', 'rola:kierownik'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/filmy',               [FilmController::class, 'adminIndex'])->name('films.index');
    Route::get('/filmy/nowy',          [FilmController::class, 'create'])->name('films.create');
    Route::post('/filmy',              [FilmController::class, 'store'])->name('films.store');
    Route::get('/filmy/{film}/edytuj', [FilmController::class, 'edit'])->name('films.edit');
    Route::put('/filmy/{film}',        [FilmController::class, 'update'])->name('films.update');
    Route::delete('/filmy/{film}',     [FilmController::class, 'destroy'])->name('films.destroy');

    Route::get('/seanse',             [SeanceController::class, 'adminIndex'])->name('seances.index');
    Route::get('/seanse/nowy',        [SeanceController::class, 'create'])->name('seances.create');
    Route::post('/seanse',            [SeanceController::class, 'store'])->name('seances.store');
    Route::delete('/seanse/{seance}', [SeanceController::class, 'destroy'])->name('seances.destroy');

    Route::get('/raporty',  [ReportController::class, 'index'])->name('reports.index');
    Route::post('/raporty', [ReportController::class, 'generate'])->name('reports.generate');
    Route::get('/analiza-filmow', [ReportController::class, 'popularnosc'])->name('reports.popularnosc');

    Route::get('/powiadomienia', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');

    Route::get('/opinie',            [OpinionController::class, 'moderacjaIndex'])->name('opinions.index');
    Route::post('/opinia/{opinion}', [OpinionController::class, 'moderacjaUpdate'])->name('opinions.update');
});

// Administrator (tylko zarządzanie użytkownikami)
Route::middleware(['auth', 'rola:administrator'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/uzytkownicy',               [AdminController::class, 'users'])->name('users');
    Route::get('/uzytkownicy/nowy',          [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/uzytkownicy',              [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/uzytkownik/{user}/edytuj',  [AdminController::class, 'edit'])->name('users.edit');
    Route::put('/uzytkownik/{user}',         [AdminController::class, 'update'])->name('users.update');
    Route::post('/uzytkownik/{user}/blokuj', [AdminController::class, 'toggleBlock'])->name('users.block');
    Route::post('/uzytkownik/{user}/rola',   [AdminController::class, 'updateRole'])->name('users.role');
});
