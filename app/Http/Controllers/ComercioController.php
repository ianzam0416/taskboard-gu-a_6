<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ComercioController extends Controller
{
    public function index(Request $request): View
    {
        $comercios = Auth::user()
            ->comercios()
            ->when($request->buscar, fn ($query) => $query->where(
                'nombre_comercio',
                'like',
                "%{$request->buscar}%"
            ))
            ->when($request->rubro, fn ($query) => $query->where(
                'rubro',
                $request->rubro
            ))
            ->withCount('transacciones')
            ->withSum('transacciones', 'monto')
            ->orderByDesc('transacciones_count')
            ->get();

        return view('comercios.index', compact('comercios'));
    }

    public function show(Comercio $comercio): View
    {
        abort_unless(
            (int) $comercio->user_id === (int) Auth::id(),
            404
        );

        $comercio->load('transacciones');

        return view('comercios.show', compact('comercio'));
    }
}
