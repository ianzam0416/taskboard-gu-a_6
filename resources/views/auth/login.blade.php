
@extends('layouts.app')

@section('contenido')
<div class="container">
    <h1>Iniciar sesión</h1>

    @if ($errors->any())
        <div>
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <div>
            <label for="email">Correo electrónico</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div>
            <label for="password">Contraseña</label>
            <input
                type="password"
                id="password"
                name="password"
                required
            >
        </div>

        <div>
            <label>
                <input type="checkbox" name="recordar" value="1">
                Recordarme
            </label>
        </div>

        <button type="submit">Entrar</button>
    </form>

    <p>
        ¿Todavía no tienes una cuenta?
        <a href="{{ route('registro') }}">Crear cuenta</a>
    </p>
</div>
@endsection
