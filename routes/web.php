<?php

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ControladorHome;
use App\Http\Controllers\Google\LoginController;
use App\Http\Controllers\Panel\ControladorCampeon;
use App\Http\Controllers\Panel\ControladorCategoria;
use App\Http\Controllers\Panel\ControladorCopa;
use App\Http\Controllers\Panel\ControladorEdicion;
use App\Http\Controllers\Panel\ControladorEquipo;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserAccesPanelMiddleware;

Route::get('/auth/redirect',[LoginController::class, 'redirect']);
Route::get('/auth/google/callback', [LoginController::class, 'callback']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [ControladorHome::class, 'index'])->name('home');
Route::get('forgot-password/{restablecer?}', [PasswordResetLinkController::class, 'create'])->name('password.request');


Route::group(['prefix' => 'Panel', 'middleware' => ['auth', 'verified', UserAccesPanelMiddleware::class]], function () {
    Route::resource('equipo', ControladorEquipo::class);
    Route::resource('categoria', ControladorCategoria::class);
    Route::resource('edicion', ControladorEdicion::class);
    Route::resource('campeon', ControladorCampeon::class);
    Route::resource('copa', ControladorCopa::class);
    Route::get('seleccionar-categoria', [ControladorCampeon::class, 'seleccionarCategoria'])->name('seleccionar-categoria');
    Route::get('/admin', [ControladorHome::class, 'admin'])
    ->name('admin'); 
});



require __DIR__.'/auth.php';
