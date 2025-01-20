<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BerandaController;

Route::get('/', [BerandaController::class, 'index'])->name('index');

// Blog
Route::prefix('blog')->name('blog.')->group(function()
{
    Route::get('/', [ArtikelController::class, 'index'])->name('index');
    Route::get('/{slug}', [ArtikelController::class, 'show'])->name('show');
});

Route::prefix('lomba')->name('lomba.')->group(function()
{
    Route::get('/', [LombaController::class, 'index'])->name('index');
    Route::get('/{slug}', [LombaController::class, 'show'])->name('show');
});

Route::prefix('event')->name('event.')->group(function()
{
    Route::get('/', [EventController::class, 'index'])->name('index');
    Route::get('/{slug}', [EventController::class, 'show'])->name('show');
    Route::post('/{slug}/beli', [EventController::class, 'enrollEvent'])->name('beli');
});

Route::get('pembayaran-sukses', function()
{
    return view('pages.invoice.success', [
        'title' => 'Pembayaran Sukses'
    ]);
})->name('pembayaran-sukses');
