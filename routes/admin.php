<?php

// Todas las rutas del panel administrativo

use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\InstitutoController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubprodcutosController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ZonaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->middleware(['can:Acceso a Administración'])->name('dashboard');

Route::resource('/zonas', ZonaController::class)
    ->middleware(['can:Acceso a Zonas']);

Route::resource('/areas', AreaController::class)
    ->middleware(['can:Acceso a Areas']);

Route::resource('/subproductos', SubprodcutosController::class)
    ->middleware(['can:Acceso a Subproductos']);

Route::resource('/roles', RoleController::class)
    ->except('show')->middleware(['can:Gestion de Roles']);

Route::resource('/permissions', PermissionController::class)
    ->except('show')->middleware(['can:Gestion de Permisos']);

Route::resource('/users', UserController::class)
    ->except('show', 'create', 'store')->middleware(['can:Gestion de Usuarios']);

Route::resource('/institutos', InstitutoController::class);
