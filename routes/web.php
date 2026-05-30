<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\MonitorController;
use App\Http\Controllers\SocioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// --- Autenticación ---
Route::get('/login',  [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.attempt');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

// --- Monitor ---
Route::get('/monitor',                        [MonitorController::class, 'panel'])->name('monitor.panel');
Route::get('/monitor/clase/crear',            [MonitorController::class, 'formCrearClase'])->name('monitor.crear.form');
Route::post('/monitor/clase/crear',           [MonitorController::class, 'crearClase'])->name('monitor.crear');
Route::get('/monitor/clase/{id}/inscritos',   [MonitorController::class, 'verInscritos'])->name('monitor.inscritos');
Route::get('/monitor/clase/{id}/editar',      [MonitorController::class, 'formEditarClase'])->name('monitor.editar.form');
Route::post('/monitor/clase/{id}/editar',     [MonitorController::class, 'editarClase'])->name('monitor.editar');
Route::post('/monitor/clase/{id}/borrar',     [MonitorController::class, 'borrarClase'])->name('monitor.borrar');

// --- Socio ---
Route::get('/socio/clases',                   [SocioController::class, 'verClases'])->name('socio.clases');
Route::get('/socio/clase/{id}/inscritos',     [SocioController::class, 'verInscritos'])->name('socio.inscritos');
Route::post('/socio/clase/{id}/reservar',     [SocioController::class, 'reservar'])->name('socio.reservar');
Route::get('/socio/reservas',                 [SocioController::class, 'misReservas'])->name('socio.reservas');
Route::post('/socio/reserva/{id}/cancelar',   [SocioController::class, 'cancelarReserva'])->name('socio.cancelar');
