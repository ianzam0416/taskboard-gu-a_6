<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransaccionResource;
use App\Models\Transaccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class TransaccionApiController extends Controller
{
    /**
     * Listar las transacciones de los comercios del usuario.
     * Permite filtrar por estado usando ?estado=Completada.
     */
    public function index(Request $request)
{
    $datos = $request->validate([
        'estado' => [
            'nullable',
            'string',
            Rule::in(['Iniciada', 'Completada', 'Fallida']),
        ],
    ]);

    $consulta = Transaccion::whereHas('comercio', function ($query) use ($request) {
        $query->where('user_id', $request->user()->id);
    });

    if (!empty($datos['estado'])) {
        $consulta->where('estado', $datos['estado']);
    }

    return TransaccionResource::collection($consulta->get());
}

    /**
     * Filtrar transacciones por estado y rango de fechas.
     * Solo muestra transacciones de los comercios del usuario autenticado.
     */
    public function filtrar(Request $request)
    {
        $datos = $request->validate([
            'estado' => [
                'nullable',
                'string',
                Rule::in(['Iniciada', 'Completada', 'Fallida']),
            ],
            'desde' => [
                'nullable',
                'date',
            ],
            'hasta' => [
                'nullable',
                'date',
                'after_or_equal:desde',
            ],
            'monto_min' => [
    'nullable',
    'numeric',
    'min:0',
],
'monto_max' => [
    'nullable',
    'numeric',
    'min:0',
    Rule::when($request->filled('monto_min'), ['gte:monto_min']),
],
        ]);

        $consulta = Transaccion::whereHas('comercio', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        });

        if (!empty($datos['estado'])) {
            $consulta->where('estado', $datos['estado']);
        }

        if (!empty($datos['desde'])) {
            $consulta->whereDate('created_at', '>=', $datos['desde']);
        }

        if (!empty($datos['hasta'])) {
            $consulta->whereDate('created_at', '<=', $datos['hasta']);
        }
        if (isset($datos['monto_min'])) {
    $consulta->where('monto', '>=', $datos['monto_min']);
}

if (isset($datos['monto_max'])) {
    $consulta->where('monto', '<=', $datos['monto_max']);
}

        return TransaccionResource::collection($consulta->get());
    }

    /**
     * Registrar una transacción.
     */
    public function store(Request $request)
    {
        $datos = Validator::make($request->all(), [
            'comercio_id' => [
                'required',
                'integer',
                Rule::exists('comercios', 'id')
                    ->where('user_id', $request->user()->id),
            ],
            'monto' => [
                'required',
                'numeric',
                'min:0.01',
                'max:999999.99',
            ],
            'cliente_nombre' => [
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'estado' => [
                'required',
                'string',
                Rule::in(['Iniciada', 'Completada', 'Fallida']),
            ],
        ])->validate();

        $transaccion = Transaccion::create($datos);

        return (new TransaccionResource($transaccion))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Consultar una transacción específica.
     */
    public function show(Request $request, string $id)
    {
        $transaccion = Transaccion::whereHas('comercio', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->findOrFail($id);

        return new TransaccionResource($transaccion);
    }

    /**
     * Actualizar una transacción del usuario autenticado.
     */
    public function update(Request $request, string $id)
    {
        $transaccion = Transaccion::whereHas('comercio', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->findOrFail($id);

        $datos = Validator::make($request->all(), [
            'comercio_id' => [
                'sometimes',
                'required',
                'integer',
                Rule::exists('comercios', 'id')
                    ->where('user_id', $request->user()->id),
            ],
            'monto' => [
                'sometimes',
                'required',
                'numeric',
                'min:0.01',
                'max:999999.99',
            ],
            'cliente_nombre' => [
                'sometimes',
                'required',
                'string',
                'min:2',
                'max:255',
            ],
            'estado' => [
                'sometimes',
                'required',
                'string',
                Rule::in(['Iniciada', 'Completada', 'Fallida']),
            ],
        ])->validate();

        $transaccion->update($datos);

        return new TransaccionResource($transaccion);
    }

    /**
     * Eliminar una transacción del usuario autenticado.
     */
    public function destroy(Request $request, string $id)
    {
        $transaccion = Transaccion::whereHas('comercio', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        })->findOrFail($id);

        $transaccion->delete();

        return response()->noContent();
    }
}
