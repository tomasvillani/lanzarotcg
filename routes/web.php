<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartasController;
use App\Http\Controllers\MisCartasController; 
use App\Http\Controllers\IntercambiosController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/cards', [CartasController::class, 'index'])->name('cards.index');
Route::get('/cards/{card}', [CartasController::class, 'show'])->name('cards.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/mycards', [MisCartasController::class, 'index'])->name('mycards.index');
    Route::get('/mycards/create', [MisCartasController::class, 'create'])->name('mycards.create');
    Route::post('/mycards', [MisCartasController::class, 'store'])->name('mycards.store');
    Route::get('/mycards/{carta}/edit', [MisCartasController::class, 'edit'])->name('mycards.edit');
    Route::put('/mycards/{carta}', [MisCartasController::class, 'update'])->name('mycards.update');
    Route::delete('/mycards/{carta}', [MisCartasController::class, 'destroy'])->name('mycards.destroy');
    Route::get('/trades/create/{card}', [IntercambiosController::class, 'create'])->name('trades.create');
    Route::post('/trades/store/{card}', [IntercambiosController::class, 'store'])->name('trades.store');
    Route::get('/trades/sent', [IntercambiosController::class, 'propuestos'])->name('trades.sent');
    Route::get('/trades/received/{card?}', [IntercambiosController::class, 'recibidos'])->name('trades.received');
    Route::get('/trades/{intercambio}', [IntercambiosController::class, 'show'])->name('trades.show');
    Route::patch('/trades/{intercambio}/aceptar', [IntercambiosController::class, 'aceptar'])->name('trades.accept');
    Route::patch('/trades/{intercambio}/rechazar', [IntercambiosController::class, 'rechazar'])->name('trades.reject');


});

require __DIR__.'/auth.php';
