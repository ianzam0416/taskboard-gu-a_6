<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\TransaccionController;
use Illuminate\Support\Facades\Route;

// Registro e inicio de sesión: disponibles sin autenticación.
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'mostrarRegistro'])
        ->name('registro');

    Route::post('/registro', [AuthController::class, 'registrar'])
        ->name('registro.store');

    Route::get('/login', [AuthController::class, 'mostrarLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.attempt');
});

// Cerrar sesión: requiere autenticación.
Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// Página principal.
Route::get('/', function () {
    return redirect()->route('comercios.index');
});

// Rutas de práctica: se mantienen fuera del grupo protegido.
Route::get('/practica/formulario-demo', function () {
    return view('practica.formulario_demo');
});

Route::post('/practica/enviar', function () {
    return 'Formulario recibido correctamente.';
})->middleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);

// Comercios y transacciones: requieren iniciar sesión.
Route::middleware('auth')->group(function () {
    Route::get('/comercios', [ComercioController::class, 'index'])
        ->name('comercios.index');

    Route::get('/comercios/{comercio}', [ComercioController::class, 'show'])
        ->name('comercios.show');

    Route::get('/comercios/{comercio}/transacciones/nueva', [TransaccionController::class, 'create'])
        ->name('transacciones.create');

    Route::post('/transacciones', [TransaccionController::class, 'store'])
        ->name('transacciones.store');

    Route::get('/transacciones', [TransaccionController::class, 'index'])
        ->name('transacciones.index');

    Route::get('/transaccion/{transaccion}', [TransaccionController::class, 'show'])
        ->name('transacciones.show');

    Route::get('/transacciones/{transaccion}/editar', [TransaccionController::class, 'edit'])
        ->name('transacciones.edit');

    Route::put('/transacciones/{transaccion}', [TransaccionController::class, 'update'])
        ->name('transacciones.update');

    Route::delete('/transacciones/{transaccion}', [TransaccionController::class, 'destroy'])
        ->name('transacciones.destroy');

    Route::patch('/transacciones/{transaccion}/mover/{estado}', [TransaccionController::class, 'moverEstado'])
        ->name('transacciones.mover');
});