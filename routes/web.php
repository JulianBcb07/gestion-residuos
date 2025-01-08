<?php

use App\Http\Controllers\GraficasController;
use App\Http\Controllers\GraficasSemanalController;
use App\Http\Controllers\GraficasSubproductosController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\MetaAnualController;
use App\Http\Controllers\PrediccionesZonasController;
use App\Http\Controllers\RegistroSemanalController;
use App\Http\Controllers\RegistroSubproductoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/gensemanal/search', [RegistroSemanalController::class, 'search'])->name('gensemanal.search');
    Route::resource('/gensemanal', RegistroSemanalController::class);
    Route::get('/gensemanal/edit/{fecha}/{turno}', [RegistroSemanalController::class, 'edit'])->name('gensemanal.editAll');
    Route::get('/gensemanal/show/{fecha}/{turno}', [RegistroSemanalController::class, 'show'])->name('gensemanal.showAll');
    Route::put('/gensemanal', [RegistroSemanalController::class, 'updateAll'])->name('gensemanal.updateAll');
    Route::get('/gensemanal/pdf/{fecha}/{turno}', [RegistroSemanalController::class, 'GenerarPDF'])->name('gensemanal.pdf');
    Route::get('/gensemanal/excel/{fecha}/{turno}', [RegistroSemanalController::class, 'GenerarExcel'])->name('gensemanal.excel');

    // Rutas para obtener datos de cada gráfica de manera dinámica de los residuos semanales
    Route::get('/graficassemanal', [GraficasSemanalController::class, 'index'])->name('graficassemanal.index');
    Route::get('/graficassemanal/data', [GraficasSemanalController::class, 'fetchGraphData'])->name('graficassemanal.data');
    Route::get('/graficassemanal/data/top3', [GraficasSemanalController::class, 'getTop3Generado'])->name('graficassemanal.data.top3');
    Route::get('/graficassemanal/data/piechart', [GraficasSemanalController::class, 'getPorcentajeResiduos'])->name('graficassemanal.data.piechart');
    Route::get('/graficassemanal/data/barchart', [GraficasSemanalController::class, 'getGraficoTotalResiduos'])->name('graficassemanal.data.barchart');
    Route::get('/graficassemanal/data/linechart', [GraficasSemanalController::class, 'getGraficoTendenciaResiduos'])->name('graficassemanal.data.linechart');

    Route::resource('/gensubproductos', RegistroSubproductoController::class);
    Route::get('/gensubproductos/edit/{instituto_id}/{inicio}/{final}', [RegistroSubproductoController::class, 'edit'])->name('gensubproductos.editAll');
    Route::get('/gensubproductos/show/{instituto_id}/{inicio}/{final}', [RegistroSubproductoController::class, 'show'])->name('gensubproductos.showAll');
    Route::put('/gensubproductos', [RegistroSubproductoController::class, 'updateMultiple'])->name('gensubproductos.updateMultiple');
    Route::get('/gensubproductos/pdf/{instituto_id}/{inicio}/{final}', [RegistroSubproductoController::class, 'GenerarPDF'])->name('gensubproductos.pdf');
    Route::get('/gensubproductos/excel/{instituto_id}/{inicio}/{final}', [RegistroSubproductoController::class, 'GenerarExcel'])->name('gensubproductos.excel');

    // Ruta para obtener datos de cada gráfica de manera dinámica
    Route::get('/graficassubproductos', [GraficasSubproductosController::class, 'index'])->name('graficassubproductos.index');
    Route::get('/graficassubproductos/data', [GraficasSubproductosController::class, 'fetchGraphData'])->name('graficassubproductos.data');
    Route::get('/graficassubproductos/data/top3', [GraficasSubproductosController::class, 'getTop3Subproductos'])->name('graficassubproductos.data.top3');
    Route::get('/graficassubproductos/data/piechart', [GraficasSubproductosController::class, 'getPorcentajeGenerado'])->name('graficassubproductos.data.piechart');
    Route::get('/graficassubproductos/data/barchart', [GraficasSubproductosController::class, 'getGraficoBarras'])->name('graficassubproductos.data.barchart');
    Route::get('/graficassubproductos/data/linechart', [GraficasSubproductosController::class, 'getGraficoTendencias'])->name('graficassubproductos.data.linechart');

    Route::get('/evidenciasGenerado/search', [ImageController::class, 'search'])->name('evidenciasGenerado.search');
    Route::resource('/evidenciasGenerado',  ImageController::class);

    Route::get('/metaAnual', [MetaAnualController::class, 'index'])->name('metaAnual.index');

    Route::get('/prediccionesZonas/obtenerPredicciones', [PrediccionesZonasController::class, 'obtenerPredicciones']);
    // Route::get('/prediccionesZonas/obtenerTodasLasPredicciones', [PrediccionesZonasController::class, 'obtenerTodasLasPredicciones']);
    Route::resource('/prediccionesZonas', PrediccionesZonasController::class);

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/graficas', function () {
        return view('graficas');
    })->name('graficas');
    Route::get('/acerca-de', function () {
        return view('acerca-de');
    })->name('acerca-de');
});
