<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Fe\HomeController;
use App\Http\Controllers\Fe\MentoringController;

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::prefix('mentoring')->name('mentoring.')->group(function()
{
    Route::get('/', [MentoringController::class, 'index'])->name('index');
});
