@extends('layouts.app')

@section('content')
    <div class="container col-md-8 mt-5">
        <h2 class="mb-4">Perfil del usuario</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->has('password_actual'))
            <div class="alert alert-danger">
                {{ $errors->first('password_actual') }}
            </div>
        @endif

        <form action="{{ route('perfil.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" id="nombre" class="form-control"
                    value="{{ old('nombre', Auth::user()->nombre) }}" required>
                @error('nombre')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Nueva contraseña <small
                        class="text-muted">(opcional)</small></label>
                <input type="password" name="password" id="password" class="form-control">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
            </div>

            <div id="grupo_password_actual" class="mb-3">
                <label for="password_actual" class="form-label">Contraseña actual <small class="text-muted">(obligatoria
                        para cambiar la contraseña)</small></label>
                <input type="password" name="password_actual" id="password_actual" class="form-control">
                @error('password_actual')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Guardar cambios</button>
            <a href="{{ route('recetas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mostramos el campo de contraseña actual cuando se escriba una contraseña nueva
            const inputContraseña = document.getElementById('password');
            const inputContraseñaActual = document.getElementById('grupo_password_actual');

            const toggleInputContraseña = () => {
                if (inputContraseña.value.trim().length > 0) {
                    inputContraseñaActual.classList.remove('d-none');
                } else {
                    inputContraseñaActual.classList.add('d-none');
                }
            };

            inputContraseña.addEventListener('input', toggleInputContraseña);
            toggleInputContraseña();
        });
    </script>
@endpush
