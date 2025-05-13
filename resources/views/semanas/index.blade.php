@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-4">
            {{-- Boton crear --}}
            <a href="{{ route('semanas.planificar') }}" class="btn btn-primary btn-lg w-100 py-3">
                📅 Crear semana
            </a>
        </div>
        <h1 class="mb-4">Semanas planificadas</h1>
        {{-- Mostramos mensaje de confirmacion si lo hay (crear semana ok) --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        {{-- Si la fecha de duplicado es erronea --}}
        @if ($errors->has('duplicar_error'))
            <div class="alert alert-danger">
                {{ $errors->first('duplicar_error') }}
            </div>
        @endif
        {{-- Si el usuario no tiene regsitrada ninguna semana --}}
        @if ($semanas->isEmpty())
            <div class="alert alert-info">Aún no has planificado ninguna semana.</div>
        @else
            {{-- Si el usuario tiene semanas creadas --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Inicio</th>
                        <th>Fin</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semanas as $semana)
                        {{-- Para cada semana mostramos --}}
                        <tr>
                            {{-- Fecha inicio --}}
                            <td>{{ \Carbon\Carbon::parse($semana->inicio)->format('d/m/Y') }}</td>
                            {{-- Fecha fin --}}
                            <td>{{ \Carbon\Carbon::parse($semana->fin)->format('d/m/Y') }}</td>
                            <td class="text-center">

                                {{-- Boton ver (GET) --}}
                                <a href="{{ route('semanas.show', $semana) }}" class="btn btn-sm btn-info">Ver</a>
                                {{-- Boton editar (GET) --}}
                                <a href="{{ route('semanas.edit', $semana) }}" class="btn btn-sm btn-warning">Editar</a>
                                {{-- Boton duplicar (POST) --}}
                                <!-- Botón que lanza el modal -->
                                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                    data-bs-target="#modalDuplicarSemana">
                                    Duplicar
                                </button>

                                <!-- Modal para seleccionar nueva fecha -->
                                <div class="modal fade" id="modalDuplicarSemana" tabindex="-1"
                                    aria-labelledby="duplicarSemanaLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <form action="{{ route('semanas.duplicarConFecha', $semana) }}" method="POST">
                                            @csrf
                                            <div class="modal-content">
                                                <input type="hidden" name="desde_modal" value="1">
                                                {{-- Para saber si se ha abierto desde el modal --}}
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="duplicarSemanaLabel">Duplicar semana</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Cerrar"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="inicio" class="form-label">Nueva fecha de
                                                            inicio</label>
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
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancelar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                {{-- Boton eliminar (POST) --}}
                                <form action="{{ route('semanas.destroy', $semana) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('¿Eliminar esta semana?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
