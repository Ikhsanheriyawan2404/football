<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\StandingController;

Route::get('/', [StandingController::class, 'index'])->name('standings');
Route::get('/clubs/data', [ClubController::class, 'data'])->name('clubs.data');
Route::resource('/clubs', ClubController::class);
Route::resource('/games', GameController::class);
