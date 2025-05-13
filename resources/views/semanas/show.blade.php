@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Nombre de la semana --}}
        <h1 class="mb-4">Semana del
            {{ \Carbon\Carbon::parse($semana->inicio)->format('d/m/Y') }}
            al
            {{ \Carbon\Carbon::parse($semana->fin)->format('d/m/Y') }}</h1>
        {{-- Si se ha editado, mostramos una confirmacion --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        {{-- Si la fecha de duplicado es erronea --}}
        @if ($errors->has('duplicar_error'))
            <div class="alert alert-danger">
                {{ $errors->first('duplicar_error') }}
            </div>
        @endif

        {{-- Detalle de los dias de la semana --}}
        @foreach ($semana->recetasSemana as $dia)
            <div class="card mb-4">
                <div class="card-header text-capitalize">
                    <strong>{{ $dia->dia_semana }}</strong>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <strong>Desayuno:</strong> {{ optional($dia->desayuno)->nombre ?? '—' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Comida:</strong> {{ optional($dia->comida)->nombre ?? '—' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Merienda:</strong> {{ optional($dia->merienda)->nombre ?? '—' }}
                        </li>
                        <li class="list-group-item">
                            <strong>Cena:</strong> {{ optional($dia->cena)->nombre ?? '—' }}
                        </li>
                    </ul>
                </div>
            </div>
        @endforeach
        <div class="d-flex justify-content-between mt-4">
            {{-- Boton duplicar --}}
            <!-- Botón que lanza el modal -->
            <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#modalDuplicarSemana">
                Duplicar
            </button>

            <!-- Modal para seleccionar nueva fecha -->
            <div class="modal fade" id="modalDuplicarSemana" tabindex="-1" aria-labelledby="duplicarSemanaLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('semanas.duplicarConFecha', $semana) }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <input type="hidden" name="desde_modal" value="1"> {{-- Para saber si se ha abierto desde el modal --}}
                            <div class="modal-header">
                                <h5 class="modal-title" id="duplicarSemanaLabel">Duplicar semana</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="inicio" class="form-label">Nueva fecha de inicio</label>
                                    <input type="date" name="inicio"
                                        class="form-control @error('inicio') is-invalid @enderror"
                                        value="{{ old('inicio') }}" required>
                                    @error('inicio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-success">Duplicar</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Boton editar --}}
            <a href="{{ route('semanas.edit', $semana) }}" class="btn btn-warning">Editar semana</a>
            {{-- Boton eliminar (muestra ventana de confirmacion) --}}
            <form action="{{ route('semanas.destroy', $semana) }}" method="POST"
                onsubmit="return confirm('¿Estás seguro de que quieres eliminar esta semana?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Eliminar semana</button>
            </form>
        </div>
        {{-- Boton volver --}}
        <a href="{{ route('semanas.index') }}" class="btn btn-outline-secondary mt-4">Volver</a>
    </div>
@endsection
