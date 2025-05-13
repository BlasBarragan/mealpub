@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Listado de Recetas</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div><br>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div><br>
        @endif

        <form method="GET" class="row g-3 mb-5 form-custom">
            <div class="col-md-4">
                <input type="text" name="nombre" class="form-control" placeholder="Buscar por nombre"
                    value="{{ request('nombre') }}">
            </div>
            <div class="col-md-3">
                <select name="tipo_receta" class="form-select">
                    <option value="">Tipo de receta</option>
                    @foreach (['entrante', 'aperitivo', 'plato_principal', 'reposteria', 'cremas_y_sopas', 'arroces_y_pastas'] as $tipo)
                        <option value="{{ $tipo }}" {{ request('tipo_receta') == $tipo ? 'selected' : '' }}>
                            {{ ucfirst(str_replace('_', ' ', $tipo)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="dificultad" class="form-select">
                    <option value="">Dificultad</option>
                    @foreach (['facil', 'medio', 'avanzado'] as $dif)
                        <option value="{{ $dif }}" {{ request('dificultad') == $dif ? 'selected' : '' }}>
                            {{ ucfirst($dif) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" name="puntuacion_min" min="0" max="5" step="0.1"
                    class="form-control" placeholder="Puntuación ≥" value="{{ request('puntuacion_min') }}">
            </div>
            <div class="col-md-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-custom">Filtrar</button>
                <a href="{{ route('recetas.index') }}" class="btn btn-outline-secondary ms-2">Reset</a>
            </div>
        </form>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('recetas.create') }}" class="btn btn-custom mb-3">Crear nueva
                receta</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-light">
                    <tr class="text-center">
                        <th>Nombre</th>
                        <th>Raciones</th>
                        <th>Puntuación</th>
                        <th>Dificultad</th>
                        <th>Tipo</th>
                        <th>Ingredientes</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recetas as $receta)
                        <tr>
                            <td>{{ $receta->nombre }}</td>
                            <td>{{ $receta->raciones }}</td>
                            <td>{{ $receta->puntuacion }}</td>
                            <td>{{ ucfirst($receta->dificultad) }}</td>
                            <td>{{ str_replace('_', ' ', ucfirst($receta->tipo_receta)) }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach ($receta->ingredientes as $ingrediente)
                                        <li>{{ $ingrediente->pivot->cantidad }} {{ $ingrediente->pivot->unidad }} de
                                            {{ $ingrediente->nombre }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td class="text-center">
                                <form action="{{ route('favoritas.toggle', $receta) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button
                                        class="btn btn-sm {{ Auth::user()->recetasFavoritas->contains($receta->id) ? 'btn-warning' : 'btn-outline-warning' }}">
                                        {{ Auth::user()->recetasFavoritas->contains($receta->id) ? '⭐ Quitar' : '☆ Añadir' }}
                                    </button>
                                </form>
                                <a href="{{ route('recetas.show', $receta) }}" class="btn btn-info btn-sm mt-1">Ver</a>
                                <button type="button" class="btn btn-sm btn-outline-primary mt-1" data-bs-toggle="modal"
                                    data-bs-target="#modalSemana{{ $receta->id }}">
                                    🗓 Añadir a semana
                                </button>
                                @auth
                                    @if ($receta->usuario_id === Auth::id())
                                        {{-- <a href="{{ route('recetas.edit', $receta) }}"
                                            class="btn btn-warning btn-sm mt-1">Editar</a> --}}
                                        <form action="{{ route('recetas.destroy', $receta) }}" method="POST"
                                            style="display:inline-block;" class="mt-1">
                                            @csrf
                                            @method('DELETE')
                                            {{-- input oculto para saber de donde viene la peticion --}}
                                            <input type="hidden" name="origen" value="index">
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Seguro que quieres eliminar esta receta?')">Eliminar</button>
                                        </form>
                                    @endif
                                @endauth
                            </td>
                        </tr>

                        <!-- Modal para añadir a semana -->
                        <div class="modal fade" id="modalSemana{{ $receta->id }}" tabindex="-1"
                            aria-labelledby="modalLabel{{ $receta->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form action="{{ route('recetas.añadirASemana') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="receta_id" value="{{ $receta->id }}">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel{{ $receta->id }}">Añadir a semana</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Cerrar"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Semana</label>
                                                <select name="semana_id" class="form-select semana-select"
                                                    data-receta="{{ $receta->id }}" required>
                                                    <option value="">Selecciona una semana</option>
                                                    @foreach ($semanas as $semana)
                                                        <option value="{{ $semana->id }}"
                                                            data-inicio="{{ $semana->inicio }}"
                                                            data-fin="{{ $semana->fin }}">
                                                            Semana del
                                                            {{ \Carbon\Carbon::parse($semana->inicio)->format('d/m/Y') }}
                                                            al {{ \Carbon\Carbon::parse($semana->fin)->format('d/m/Y') }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Día</label>
                                                <select name="dia_semana" class="form-select" id="dias-{{ $receta->id }}"
                                                    required>
                                                    <option value="">Selecciona una semana primero</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Momento</label>
                                                <select name="momento" class="form-select" required>
                                                    <option value="desayuno">Desayuno</option>
                                                    <option value="comida">Comida</option>
                                                    <option value="merienda">Merienda</option>
                                                    <option value="cena">Cena</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Añadir</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const semanaSelect = document.querySelector('.semana-select[data-receta="{{ $receta->id }}"]');
                                const diasSelect = document.getElementById('dias-{{ $receta->id }}');

                                semanaSelect.addEventListener('change', function() {
                                    const selected = this.options[this.selectedIndex];
                                    const inicio = new Date(selected.dataset.inicio);
                                    const fin = new Date(selected.dataset.fin);

                                    const diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes',
                                        'sábado'
                                    ];

                                    diasSelect.innerHTML = '<option value=\"\">Selecciona un día</option>';

                                    for (let d = new Date(inicio); d <= fin; d.setDate(d.getDate() + 1)) {
                                        const nombre = diasSemana[d.getDay()];
                                        const option = document.createElement('option');
                                        option.value = nombre;
                                        option.textContent = nombre.charAt(0).toUpperCase() + nombre.slice(1);
                                        diasSelect.appendChild(option);
                                    }
                                });
                            });
                        </script>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
