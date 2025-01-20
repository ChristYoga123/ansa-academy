<?php

use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\BerandaController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BerandaController::class, 'index'])->name('index');

// Blog
Route::prefix('blog')->name('blog.')->group(function()
{
    Route::get('/', [ArtikelController::class, 'index'])->name('index');
    Route::get('/{slug}', [ArtikelController::class, 'show'])->name('show');
});
