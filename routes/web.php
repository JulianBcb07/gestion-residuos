<?php

use App\Http\Controllers\GraficasController;
use App\Http\Controllers\RegistroSemanalController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/gensemanal', RegistroSemanalController::class);

Route::get('graficas', [GraficasController::class, 'show'])->name('graficas');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
