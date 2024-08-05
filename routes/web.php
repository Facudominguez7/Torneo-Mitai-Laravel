<?php

use App\Http\Controllers\ControladorHome;
use App\Http\Controllers\Panel\ControladorCategoria;
use App\Http\Controllers\Panel\ControladorEdicion;
use App\Http\Controllers\Panel\ControladorEquipo;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserAccesPanelMiddleware;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
 
Route::get('/auth/google/callback', function () {
    $user_google = Socialite::driver('google')->stateless()->user();
    dd($user_google);
    // $user->token
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [ControladorHome::class, 'index'])->name('home');

Route::group(['prefix' => 'Panel', 'middleware' => ['auth', 'verified', UserAccesPanelMiddleware::class]], function () {
    Route::resource('equipo', ControladorEquipo::class);
    Route::resource('categoria', ControladorCategoria::class);
    Route::resource('edicion', ControladorEdicion::class);
    Route::get('/admin', [ControladorHome::class, 'admin'])
    ->name('admin'); 
});



require __DIR__.'/auth.php';
