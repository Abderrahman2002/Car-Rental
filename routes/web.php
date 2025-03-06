<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoitureController;
use App\Http\Controllers\LocationController;

Route::get('/', function () {
    return redirect()->route('voitures.index');
});

Route::resource('voitures', VoitureController::class);
Route::resource('locations', LocationController::class);
