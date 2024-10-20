<?php

// Todas las rutas del panel administrativo

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.dashboard');
})->middleware(['can:Acceso a Inicio'])->name('dashboard');

Route::resource('/roles', RoleController::class)
    ->except('show')->middleware(['can:Gestion de Roles']);

Route::resource('/permissions', PermissionController::class)
    ->except('show')->middleware(['can:Gestion de Permisos']);

Route::resource('/users', UserController::class)
    ->except('show', 'create', 'store')->middleware(['can:Gestion de Usuarios']);
