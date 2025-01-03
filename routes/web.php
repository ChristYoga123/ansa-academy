<?php

use App\Http\Controllers\Fe\HomeController;
use Illuminate\Support\Facades\Route;

// Home Routes
Route::get('/', [HomeController::class, 'index'])->name('index');
