<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Comercio;
use App\Http\Resources\ComercioResource;
use App\Http\Controllers\Api\TransaccionApiController;

// Consultar el usuario autenticado
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Listar los comercios del usuario autenticado
Route::get('/comercios', function (Request $request) {
    return ComercioResource::collection(
        Comercio::where('user_id', $request->user()->id)->get()
    );
})->middleware('auth:sanctum');

// Consultar un comercio específico del usuario autenticado
Route::get('/comercios/{comercio}', function (Request $request, Comercio $comercio) {
    abort_unless(
        (int) $comercio->user_id === (int) $request->user()->id,
        404
    );

    return new ComercioResource($comercio);
})->middleware('auth:sanctum');

// API REST de transacciones
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/transacciones', [TransaccionApiController::class, 'index']);
    Route::post('/transacciones', [TransaccionApiController::class, 'store']);
    Route::get('/transacciones/{id}', [TransaccionApiController::class, 'show']);
    Route::delete('/transacciones/{id}', [TransaccionApiController::class, 'destroy']);
});
