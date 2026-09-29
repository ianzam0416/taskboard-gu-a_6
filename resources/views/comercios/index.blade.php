{{-- Semana 9 · Blade --}}
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

        <select name="rubro">
            <option value="">Todos los rubros</option>

            <option value="Restaurante"
                {{ request('rubro') === 'Restaurante' ? 'selected' : '' }}>
                Restaurante
            </option>

            <option value="Ferretería"
                {{ request('rubro') === 'Ferretería' ? 'selected' : '' }}>
                Ferretería
            </option>
        </select>

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
                <x-badge-actividad
                    :totalTransacciones="$comercio->transacciones_count"
                />

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