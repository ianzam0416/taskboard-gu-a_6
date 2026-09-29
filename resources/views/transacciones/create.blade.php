{{--
    transacciones/create.blade.php
--}}

@extends('layouts.app')

@section('titulo', 'Nueva transacción')

@section('contenido')

    <h1>Nueva transacción</h1>

    <p class="meta">Comercio: {{ $comercio->nombre_comercio }}</p>

    <form action="{{ route('transacciones.store') }}" method="POST">

       @csrf

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

<input type="hidden" name="comercio_id" value="{{ $comercio->id }}">

        <input type="hidden" name="comercio_id" value="{{ $comercio->id }}">
        @error('comercio_id')
    <span class="error">{{ $message }}</span>
@enderror

       <label for="cliente">Cliente</label>
<input
    id="cliente"
    name="cliente_nombre"
    type="text"
    value="{{ old('cliente_nombre') }}"
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
    value="{{ old('monto') }}"
>

@error('monto')
    <span class="error">{{ $message }}</span>
@enderror

<br>
        
        <button type="submit">Registrar</button>

    </form>

@endsection