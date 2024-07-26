<?php

use App\Http\Controllers\Panel\ControladorEquipo;
use App\Http\Controllers\ControladorHome;
use Illuminate\Support\Facades\Route;

Route::get('/', [ControladorHome::class, 'index']);
Route::get('/admin', [ControladorHome::class, 'admin'])->name('admin');
Route::resource('equipo', ControladorEquipo::class);


