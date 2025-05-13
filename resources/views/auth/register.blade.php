@extends('layouts.guest')

@section('content')
    <div class="container col-md-6 mt-5">
        @auth
            <div class="alert alert-info">Ya has iniciado sesión como <strong>{{ Auth::user()->nombre }}</strong>. <a
                    href="{{ url('/') }}">Ir al inicio</a>.</div>
        @else
            <h2 class="mb-4">Registro de usuario</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" value="{{ old('nombre') }}"
                        required>
                    @error('nombre')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo electrónico</label>
                    <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}"
                        required>
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                    @error('password')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation" class="form-control" id="password_confirmation"
                        required>
                </div>

                <button type="submit" class="btn btn-success">Registrarse</button>
            </form>
        @endauth
    </div>
@endsection
