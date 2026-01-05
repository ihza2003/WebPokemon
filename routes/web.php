<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokemonController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [PokemonController::class, 'index'])->name('pokemon.index');
