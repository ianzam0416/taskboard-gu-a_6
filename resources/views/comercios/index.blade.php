{{-- Semana 8 · Blade --}}
{{-- resources/views/comercios/index.blade.php --}}
@extends('layouts.app')

@section('titulo', 'Comercios afiliados')

@section('contenido')
    <h1>Comercios afiliados a la pasarela</h1>
    <form action="{{ route('comercios.index') }}" method="GET">
    <input
        type="text"
        name="buscar"
        placeholder="Buscar comercio..."
        value="{{ request('buscar') }}"
    >
    <button type="submit">Buscar</button>
</form>

    <ul class="comercios">
        @forelse ($comercios as $comercio)
            <li class="card">
                <a href="{{ route('comercios.show', $comercio) }}">
                    {{ $comercio->nombre_comercio }}
                </a>

                <span class="meta">
                    — {{ $comercio->rubro }}
                    ({{ $comercio->transacciones_count }} transacciones)
                </span>

                <br>

                {{-- Nivel de actividad --}}
                @if ($comercio->transacciones_count === 0)
                    <span class="badge gris">Sin actividad</span>
                @elseif ($comercio->transacciones_count <= 2)
                    <span class="badge amarillo">Actividad baja</span>
                @else
                    <span class="badge verde">Alta actividad</span>
                @endif

                {{-- Monto total --}}
                <p class="meta">
                    Monto total:
                    ${{ number_format($comercio->transacciones_sum_monto ?? 0, 2) }}
                </p>
            </li>
        @empty
            <li class="card">
                Aún no hay comercios afiliados.
            </li>
        @endforelse
    </ul>
@endsection