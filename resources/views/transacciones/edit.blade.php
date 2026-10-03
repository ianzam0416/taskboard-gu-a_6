@extends('layouts.app')

@section('titulo', 'Editar transacción')

@section('contenido')

    <h1>Editar transacción</h1>

    <p class="meta">
        Comercio: {{ $transaccion->comercio->nombre_comercio }}
    </p>

    @if ($errors->any())
        <div class="errores">
            <strong>Hay errores en el formulario:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('transacciones.update', $transaccion) }}"
        method="POST"
    >

        @csrf
        @method('PUT')

        <input
            type="hidden"
            name="comercio_id"
            value="{{ $transaccion->comercio_id }}"
        >

        @error('comercio_id')
            <span class="error">{{ $message }}</span>
        @enderror

        <label for="cliente">Cliente</label>

        <input
            id="cliente"
            name="cliente_nombre"
            type="text"
            value="{{ old('cliente_nombre', $transaccion->cliente_nombre) }}"
        >

        @error('cliente_nombre')
            <span class="error">{{ $message }}</span>
        @enderror

        <br>

        <label for="monto">Monto</label>

        <input
            id="monto"
            name="monto"
            type="number"
            step="0.01"
            value="{{ old('monto', $transaccion->monto) }}"
        >

        @error('monto')
            <span class="error">{{ $message }}</span>
        @enderror

        <br>

        <button type="submit">Guardar cambios</button>

    </form>

@endsection
