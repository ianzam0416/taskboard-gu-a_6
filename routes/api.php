<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Comercio;
use App\Http\Resources\ComercioResource;
use App\Http\Controllers\Api\TransaccionApiController;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Iniciar sesión desde clientes API y generar token de Sanctum
Route::post('/login', function (Request $request) {

    $datos = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
        'dispositivo' => ['nullable', 'string'],
    ]);

    $user = User::where('email', $datos['email'])->first();

    if (!$user || !Hash::check($datos['password'], $user->password)) {
        return response()->json([
            'message' => 'Credenciales incorrectas.',
        ], 401);
    }

    $token = $user->createToken(
        $datos['dispositivo'] ?? 'bruno'
    )->plainTextToken;

    return response()->json([
        'token' => $token,
        'user' => $user,
    ], 201);
});
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
