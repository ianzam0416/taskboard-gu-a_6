<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Comercio;
use App\Http\Resources\ComercioResource;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\TransaccionApiController;

// Autenticación API
Route::post('/login', [AuthApiController::class, 'login'])
    ->middleware('throttle:5,1');

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {

    // Consultar usuario autenticado
    Route::get('/yo', [AuthApiController::class, 'yo']);

    // Cerrar sesión
    Route::post('/logout', [AuthApiController::class, 'logout']);

    // Consultar usuario (ruta anterior conservada)
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Listar comercios del usuario autenticado
    Route::get('/comercios', function (Request $request) {
        return ComercioResource::collection(
            Comercio::where('user_id', $request->user()->id)->get()
        );
    });

    // Consultar un comercio específico
    Route::get('/comercios/{comercio}', function (Request $request, Comercio $comercio) {
        abort_unless(
            (int) $comercio->user_id === (int) $request->user()->id,
            404
        );

        return new ComercioResource($comercio);
    });

    // API REST de transacciones
    Route::get('/transacciones', [TransaccionApiController::class, 'index']);
    Route::post('/transacciones', [TransaccionApiController::class, 'store']);
    Route::get('/transacciones/{id}', [TransaccionApiController::class, 'show']);
    Route::put('/transacciones/{id}', [TransaccionApiController::class, 'update']);
    Route::patch('/transacciones/{id}', [TransaccionApiController::class, 'update']);
    Route::delete('/transacciones/{id}', [TransaccionApiController::class, 'destroy']);
});
