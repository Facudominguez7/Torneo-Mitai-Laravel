<?php

use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ControladorHome;
use App\Http\Controllers\Panel\ControladorTablaGoleadores;
use App\Http\Controllers\Google\LoginController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\Panel\ControladorCampeon;
use App\Http\Controllers\Panel\ControladorCategoria;
use App\Http\Controllers\Panel\ControladorCopa;
use App\Http\Controllers\Panel\ControladorEdicion;
use App\Http\Controllers\Panel\ControladorEquipo;
use App\Http\Controllers\Panel\ControladorEquiposEdiciones;
use App\Http\Controllers\Panel\ControladorEquiposGrupos;
use App\Http\Controllers\Panel\ControladorFase;
use App\Http\Controllers\Panel\ControladorFecha;
use App\Http\Controllers\Panel\ControladorGoleador;
use App\Http\Controllers\Panel\ControladorGrupos;
use App\Http\Controllers\Panel\ControladorInstanciaFinal;
use App\Http\Controllers\Panel\ControladorPartidos;
use App\Http\Controllers\Panel\ControladorPlanillaJugador;
use App\Http\Controllers\Panel\ControladorSubcampeon;
use App\Http\Controllers\Panel\ControladorValla;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\UserAccesPanelMiddleware;
use App\Models\Categoria;

Route::get('/auth/redirect', [LoginController::class, 'redirect']);
Route::get('/auth/google/callback', [LoginController::class, 'callback']);
Route::get('Testloginfo', [LogController::class, 'Testloginfo'])->name('testloginfo');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [ControladorHome::class, 'index'])->name('home');
Route::get('/campeones', [ControladorHome::class, 'campeones'])->name('campeones');
Route::get('/subcampeones', [ControladorHome::class, 'subcampeones'])->name('subcampeones');
Route::get('/goleadores', [ControladorHome::class, 'goleadores'])->name('goleadores');
Route::get('/vallas', [ControladorHome::class, 'vallas'])->name('vallas');
Route::get('/fixture', [ControladorHome::class, 'fixture'])->name('fixture');
Route::get('/tabla-de-posiciones', [ControladorHome::class, 'tablaPosiciones'])->name('tabla-posiciones');
Route::get('/tabla-de-goleadores', [ControladorHome::class, 'tablaGoleadores'])->name('tabla-goleadores');
Route::get('/instancias-finales', [ControladorHome::class, 'instanciasFinales'])->name('instancias-finales');
Route::get('forgot-password/{restablecer?}', [PasswordResetLinkController::class, 'create'])->name('password.request');



Route::group(['prefix' => 'Panel', 'middleware' => ['auth', 'verified', UserAccesPanelMiddleware::class]], function () {
    Route::resource('equipo', ControladorEquipo::class);
    Route::resource('categoria', ControladorCategoria::class);
    Route::resource('edicion', ControladorEdicion::class);
    Route::resource('campeon', ControladorCampeon::class);
    Route::resource('subcampeon', ControladorSubcampeon::class);
    Route::resource('copa', ControladorCopa::class);
    Route::resource('fecha', ControladorFecha::class);
    Route::resource('goleador', ControladorGoleador::class);
    Route::resource('valla', ControladorValla::class);
    Route::resource('grupos', ControladorGrupos::class);
    Route::resource('equipogrupo', ControladorEquiposGrupos::class);
    Route::resource('equipoedicion', ControladorEquiposEdiciones::class);
    Route::resource('partido', ControladorPartidos::class);
    Route::resource('tabla_goleador', ControladorTablaGoleadores::class);
    Route::resource('instancia_final', ControladorInstanciaFinal::class);
    Route::get('/instancia_final/{idEdicion}/{horario?}', [ControladorInstanciaFinal::class, 'index'])->name('instancia_final');
    Route::resource('fase', ControladorFase::class);
    Route::match(['get', 'post'], 'cargar-resultado', [ControladorPartidos::class, 'cargarResultado'])->name('cargar-resultado');
    Route::match(['get', 'post'], 'cargar-resultado-instancia', [ControladorInstanciaFinal::class, 'cargarResultadoInstancia'])->name('cargar-resultado-instancia');
    Route::get('seleccionar-categoria', [ControladorCampeon::class, 'seleccionarCategoria'])->name('seleccionar-categoria');
    Route::get('seleccionar-edicion', [ControladorEquiposEdiciones::class, 'seleccionarEdicion'])->name('seleccionar-edicion');
    Route::get('/admin', [ControladorHome::class, 'admin'])
        ->name('admin');
    Route::prefix('planilla')->group(function () {
        Route::get('/{partidoId}/{idEdicion}/{tipoPartido}/{horario?}', [ControladorPlanillaJugador::class, 'mostrarPlanilla'])->name('planilla.show');
        Route::post('/agregar-jugador', [ControladorPlanillaJugador::class, 'agregarJugador'])->name('planilla.agregarJugador');
        Route::post('/actualizar-jugador', [ControladorPlanillaJugador::class, 'actualizarJugadores'])->name('planilla.actualizarJugadores');
    });
    // Rutas para obtener las categorías y equipos por AJAX
    // En routes/web.php
    Route::get('/categorias-por-edicion/{id}', [ControladorEdicion::class, 'categoriasPorEdicion'])->name('categorias.por.edicion');
    Route::get('/equipos-por-categoria/{id}', [ControladorEdicion::class, 'equiposPorCategoria']);
    Route::get('/reporte-jugadores/{equipoId}/{idEdicion}/{partidoId}', [ControladorPlanillaJugador::class, 'generarReportePDF'])->name('reporte.jugadores');
});



require __DIR__ . '/auth.php';
