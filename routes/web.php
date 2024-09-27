<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/shutter', 'shutter')->name('shutter');
    Route::view('/freepik', 'freepik')->name('freepik');
    Route::view('/istock', 'istock')->name('istock');
});

Route::prefix('sending')->group(function () {
    Route::post('/shutter', [OrderController::class, 'downloadImagesAtShutter'])->name('sendShutter');
    Route::post('/freepik', [OrderController::class, 'downloadImagesAtFreepik'])->name('sendFreepik');
    Route::post('/istock', [OrderController::class, 'downloadImagesAtiStock'])->name('sendiStock');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
