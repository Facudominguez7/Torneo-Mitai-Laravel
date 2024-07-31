<?php

use App\Http\Controllers\Panel\ControladorEquipo;
use App\Http\Controllers\Panel\ControladorCategoria;
use App\Http\Controllers\ControladorHome;
use App\Http\Controllers\Panel\ControladorEdicion;
use Illuminate\Support\Facades\Route;

Route::get('/', [ControladorHome::class, 'index']);
Route::get('/admin', [ControladorHome::class, 'admin'])->name('admin');

Route::group(['prefix' => 'Panel'], function () {
    Route::resource('equipo', ControladorEquipo::class);
    Route::resource('categoria', ControladorCategoria::class);
    Route::resource('edicion', ControladorEdicion::class);
});
