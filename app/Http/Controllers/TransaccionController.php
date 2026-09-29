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
}