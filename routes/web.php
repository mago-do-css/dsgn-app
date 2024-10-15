<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/teste', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/shutter', function () {
    return view('shutter');
})->middleware(['auth', 'verified'])->name('shutter');

Route::get('/freepik', function () {
    return view('freepik');
})->middleware(['auth', 'verified'])->name('freepik');

Route::get('/istock', function () {
    return view('istock');
})->middleware(['auth', 'verified'])->name('istock');

 
Route::post('/sending-shutter', [OrderController::class, 'downloadImageByUrl'])->name('sendShutter');
Route::post('/sending-freepik', [OrderController::class, 'downloadImagesAtFreepik'])->name('sendFreepik');
Route::post('/sending-istock', [OrderController::class, 'downloadImagesAtiStock'])->name('sendiStock');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';