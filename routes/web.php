<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/teste', function () {
    return view('dashboardteste');
})->middleware(['auth', 'verified'])->name('dashboardteste');

Route::middleware('auth')->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');  
    Route::get('/historico', [HistoryController::class, 'getImagesByFilter'])->name('history');  
});

// TODO: VERIFICAR SE É NECESSÁRIO TER A CONFIRMAÇÃO DE EMAIL
// ['auth', 'verified']
Route::prefix('sending')->group(function () {
    Route::post('/stock', [OrderController::class, 'downloadImageByUrl'])->name('sendStock'); 
    Route::post('/stock_teste', [OrderController::class, 'downloadImageByUrl'])->name('sendStocTeste'); 
    Route::get('/traduzir_teste', [HistoryController::class, 'traduzirTextoTeste'])->name('traduzirTeste'); 
})->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';