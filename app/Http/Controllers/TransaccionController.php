<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarTransaccionRequest;
use App\Models\Comercio;
use App\Models\Transaccion;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class TransaccionController extends Controller
{
    public function index(): JsonResponse
    {
        $transacciones = Transaccion::with('comercio')->get();

        return response()->json($transacciones);
    }

    public function show(Transaccion $transaccion): JsonResponse
    {
        $transaccion->load('comercio');

        return response()->json($transaccion);
    }

    public function create(Comercio $comercio): View
    {
        return view('transacciones.create', compact('comercio'));
    }

    public function store(GuardarTransaccionRequest $request)
    {
        $transaccion = Transaccion::create($request->only([
            'comercio_id',
            'cliente_nombre',
            'monto',
        ]));

        return redirect()
            ->route('comercios.show', $transaccion->comercio_id)
            ->with('mensaje', 'Transacción registrada con éxito.');
    }
    public function edit(Transaccion $transaccion)
{
    $comercios = Comercio::orderBy('nombre_comercio')->get();

    return view('transacciones.edit', compact('transaccion', 'comercios'));
}

public function update(
    GuardarTransaccionRequest $request,
    Transaccion $transaccion
) {
    $transaccion->update($request->validated());

    return redirect()
        ->route('comercios.show', $transaccion->comercio_id)
        ->with('mensaje', 'Transacción actualizada correctamente.');
}
public function destroy(Transaccion $transaccion)
{
    $comercioId = $transaccion->comercio_id;

    $transaccion->delete();

    return redirect()
        ->route('comercios.show', $comercioId)
        ->with('mensaje', 'Transacción eliminada.');
}
public function moverEstado(Transaccion $transaccion, string $estado)
{
    $transiciones = [
        'Iniciada'   => ['Completada', 'Fallida'],
        'Completada' => [],
        'Fallida'    => ['Iniciada'],
    ];

    if (!in_array($estado, ['Iniciada', 'Completada', 'Fallida'])) {
        abort(400, 'Estado no válido.');
    }

    if (!in_array($estado, $transiciones[$transaccion->estado] ?? [])) {
        abort(
            400,
            "No se puede mover de {$transaccion->estado} a {$estado}."
        );
    }

    $transaccion->update([
        'estado' => $estado
    ]);

    return redirect()
        ->route('comercios.show', $transaccion->comercio_id)
        ->with('mensaje', "Transacción movida a {$estado}.");
}
}
