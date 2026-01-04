<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('cards.index');
});


Route::get('/cards', [CardController::class, 'index'])->name('cards.index');

// Auth-only routes MUST be above the {card} route
Route::middleware('auth')->group(function () {
    Route::get('/cards/create', [CardController::class, 'create'])->name('cards.create');
    Route::post('/cards', [CardController::class, 'store'])->name('cards.store');

    Route::get('/cards/{card}/edit', [CardController::class, 'edit'])->name('cards.edit');
    Route::put('/cards/{card}', [CardController::class, 'update'])->name('cards.update');
    Route::delete('/cards/{card}', [CardController::class, 'destroy'])->name('cards.destroy');
});

// This must be last, otherwise it eats "/cards/create"
Route::get('/cards/{card}', [CardController::class, 'show'])->name('cards.show');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
