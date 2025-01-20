<?php

use Illuminate\Support\Facades\Route;
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
