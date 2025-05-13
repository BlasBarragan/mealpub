@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Mis recetas</h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div><br>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div><br>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('recetas.create') }}" class="btn btn-custom mb-3">Crear nueva
                receta</a>
        </div>

        @if ($recetas->isEmpty())
            <div class="alert alert-info text-center">Aún no has creado ninguna receta.</div>
        @else
            <div class="row">
                @foreach ($recetas as $receta)
                    <div class="col-md-4 mb-4">
                        <div class="card card-custom h-100 d-flex flex-column">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-center">{{ $receta->nombre }}</h5>
                                <p class="card-text flex-grow-1">
                                    <strong>Tipo:</strong> {{ str_replace('_', ' ', ucfirst($receta->tipo_receta)) }}<br>
                                    <strong>Dificultad:</strong> {{ ucfirst($receta->dificultad) }}<br>
                                    <strong>Puntuación:</strong> {{ $receta->puntuacion }} ⭐
                                </p>
                            </div>
                            <div class="card-footer d-flex flex-wrap justify-content-center gap-2">
                                <a href="{{ route('recetas.show', $receta) }}" class="btn btn-sm btn-info">Ver</a>

                                <form action="{{ route('favoritas.toggle', $receta) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button
                                        class="btn btn-sm {{ Auth::user()->recetasFavoritas->contains($receta->id) ? 'btn-warning' : 'btn-outline-warning' }}">
                                        {{ Auth::user()->recetasFavoritas->contains($receta->id) ? '⭐ Quitar' : '☆ Añadir' }}
                                    </button>
                                </form>

                                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalSemana{{ $receta->id }}">
                                    🗓 Añadir a semana
                                </button>

                                <a href="{{ route('recetas.edit', $receta) }}"
                                    class="btn btn-warning btn-sm mt-1">Editar</a>
                                <form action="{{ route('recetas.destroy', $receta) }}" method="POST"
                                    style="display:inline-block;" class="mt-1">
                                    @csrf
                                    @method('DELETE')
                                    {{-- input oculto para saber de donde viene la peticion --}}
                                    <input type="hidden" name="origen" value="mis">
                                    <button class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Seguro que quieres eliminar esta receta?')">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Añadir a Semana -->
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
                                                        al
                                                        {{ \Carbon\Carbon::parse($semana->fin)->format('d/m/Y') }}
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
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.semana-select').forEach(select => {
                select.addEventListener('change', function() {
                    const recetaId = this.dataset.receta;
                    const diasSelect = document.getElementById('dias-' + recetaId);
                    const selected = this.options[this.selectedIndex];

                    const inicio = new Date(selected.dataset.inicio);
                    const fin = new Date(selected.dataset.fin);
                    const diasSemana = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves',
                        'viernes', 'sábado'
                    ];

                    diasSelect.innerHTML = '<option value="">Selecciona un día</option>';

                    for (let d = new Date(inicio); d <= fin; d.setDate(d.getDate() + 1)) {
                        const nombre = diasSemana[d.getDay()];
                        const option = document.createElement('option');
                        option.value = nombre;
                        option.textContent = nombre.charAt(0).toUpperCase() + nombre.slice(1);
                        diasSelect.appendChild(option);
                    }
                });
            });
        });
    </script>
@endsection
