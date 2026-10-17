
@extends('layouts.app')

@section('contenido')
<div class="container">
    <h1>Crear cuenta</h1>

    @if (session('mensaje'))
        <p>{{ session('mensaje') }}</p>
    @endif

    <form method="POST" action="{{ route('registro.store') }}">
        @csrf

        <div>
            <label for="name">Nombre completo</label>
            <input
                type="text"
                id="name"
                name="name"
                value="{{ old('name') }}"
                required
            >
            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
            @error('password')
                <p>{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation">
                Confirmar contraseña
            </label>
            <input
                type="password"
                id="password_confirmation"
                name="password_confirmation"
                required
            >
        </div>

        <button type="submit">Crear cuenta</button>
    </form>

    <p>
        ¿Ya tienes una cuenta?
        <a href="{{ route('login') }}">Inicia sesión</a>
    </p>
</div>
@endsection
