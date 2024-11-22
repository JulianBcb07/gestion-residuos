<?php

use App\Http\Controllers\GraficasController;
use App\Http\Controllers\GraficasSubproductosController;
use App\Http\Controllers\ImageController;
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

// Ruta para obtener datos de cada gráfica de manera dinámica
Route::get('/graficassubproductos', [GraficasSubproductosController::class, 'index'])->name('graficassubproductos.index');
Route::get('/graficassubproductos/data', [GraficasSubproductosController::class, 'fetchGraphData'])->name('graficassubproductos.data');
Route::get('/graficassubproductos/data/top3', [GraficasSubproductosController::class, 'getTop3Subproductos'])->name('graficassubproductos.data.top3');
Route::get('/graficassubproductos/data/piechart', [GraficasSubproductosController::class, 'getPorcentajeGenerado'])->name('graficassubproductos.data.piechart');
Route::get('/graficassubproductos/data/barchart', [GraficasSubproductosController::class, 'getGraficoBarras'])->name('graficassubproductos.data.barchart');
Route::get('/graficassubproductos/data/linechart', [GraficasSubproductosController::class, 'getGraficoTendencias'])->name('graficassubproductos.data.linechart');

Route::get('/evidenciasGenerado/search', [ImageController::class, 'search'])->name('evidenciasGenerado.search');
Route::resource('/evidenciasGenerado',  ImageController::class);



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
