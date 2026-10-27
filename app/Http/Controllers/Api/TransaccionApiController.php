<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransaccionResource;
use App\Models\Comercio;
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
        $consulta = Transaccion::whereHas('comercio', function ($query) use ($request) {
            $query->where('user_id', $request->user()->id);
        });

        if ($request->filled('estado')) {
            $consulta->where('estado', $request->query('estado'));
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
            'monto' => ['required', 'numeric', 'min:0.01'],
            'cliente_nombre' => ['required', 'string', 'min:2', 'max:255'],
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
