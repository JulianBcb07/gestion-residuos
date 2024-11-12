<?php

use App\Http\Controllers\GraficasController;
use App\Http\Controllers\GraficasSubproductosController;
use App\Http\Controllers\RegistroSemanalController;
use App\Http\Controllers\RegistroSubproductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/gensemanal', RegistroSemanalController::class);
Route::resource('/gensubproductos', RegistroSubproductoController::class);
Route::get('/gensubproductos/edit/{instituto_id}/{inicio}/{final}', [RegistroSubproductoController::class, 'edit'])->name('gensubproductos.edit');
Route::get('/gensubproductos/show/{instituto_id}/{inicio}/{final}', [RegistroSubproductoController::class, 'show'])->name('gensubproductos.show');
Route::put('/gensubproductos', [RegistroSubproductoController::class, 'updateMultiple'])->name('gensubproductos.updateMultiple');

Route::resource('/graficassubproductos', GraficasSubproductosController::class);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/graficas', function () {
        return view('graficas');
    })->name('graficas');
});
