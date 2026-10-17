<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ComercioController;
use App\Http\Controllers\TransaccionController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Autenticación de usuarios
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/registro', [
        AuthController::class,
        'mostrarRegistro'
    ])->name('registro');

    Route::post('/registro', [
        AuthController::class,
        'registrar'
    ])->name('registro.store');

    Route::get('/login', [
        AuthController::class,
        'mostrarLogin'
    ])->name('login');

    Route::post('/login', [
        AuthController::class,
        'login'
    ])->name('login.attempt');
});

Route::post('/logout', [
    AuthController::class,
    'logout'
])->middleware('auth')->name('logout');


Route::get('/', function () {
    return redirect()->route('comercios.index');
});

Route::get('/comercios', [ComercioController::class, 'index'])
    ->name('comercios.index');

Route::get('/comercios/{comercio}', [ComercioController::class, 'show'])
    ->name('comercios.show');

Route::get('/practica/formulario-demo', function () {
    return view('practica.formulario_demo');
});

Route::post('/practica/enviar', function () {
    return 'Formulario recibido correctamente.';
})->middleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);

Route::get('/comercios/{comercio}/transacciones/nueva', [
    TransaccionController::class,
    'create'
])->name('transacciones.create');

Route::post('/transacciones', [
    TransaccionController::class,
    'store'
])->name('transacciones.store');

Route::get('/transacciones', [
    TransaccionController::class,
    'index'
])->name('transacciones.index');

Route::get('/transaccion/{transaccion}', [
    TransaccionController::class,
    'show'
])->name('transacciones.show');

// Semana 11: editar, actualizar y eliminar transacciones

Route::get('/transacciones/{transaccion}/editar', [
    TransaccionController::class,
    'edit'
])->name('transacciones.edit');

Route::put('/transacciones/{transaccion}', [
    TransaccionController::class,
    'update'
])->name('transacciones.update');

Route::delete('/transacciones/{transaccion}', [
    TransaccionController::class,
    'destroy'
])->name('transacciones.destroy');
// Semana 11 viernes: mover estado de una transacción
Route::patch('/transacciones/{transaccion}/mover/{estado}', [
    TransaccionController::class,
    'moverEstado'
])->name('transacciones.mover');