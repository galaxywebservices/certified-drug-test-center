<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Design 1: Modern Patriotic Healthcare & Direct Portal (Default Home)
Route::get('/', [HomeController::class, 'design1'])->name('home.design1');

// Design 2: Corporate Clean Trust & Speed (Alternate Look)
Route::get('/design-2', [HomeController::class, 'design2'])->name('home.design2');
