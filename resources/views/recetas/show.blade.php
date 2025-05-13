@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="mb-4 text-center">Receta: {{ $receta->nombre }}</h1>

        @auth
            <div class="d-flex flex-wrap align-items-center gap-2 mb-4 justify-content-center">
                <form action="{{ route('favoritas.toggle', $receta) }}" method="POST">
                    @csrf
                    <button
                        class="btn btn-sm {{ Auth::user()->recetasFavoritas->contains($receta->id) ? 'btn-warning' : 'btn-outline-warning' }}">
                        {{ Auth::user()->recetasFavoritas->contains($receta->id) ? '⭐ Quitar de favoritas' : '☆ Añadir a favoritas' }}
                    </button>
                </form>

                <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                    data-bs-target="#modalSemana{{ $receta->id }}">
                    🗓 Añadir a semana
                </button>
            </div>
        @endauth

        <div class="card card-custom mb-5 p-4">
            <div class="row gy-4">
                <div class="col-md-6 col-12">
                    <p><strong>Tipo:</strong> {{ str_replace('_', ' ', ucfirst($receta->tipo_receta)) }}</p>
                    <p><strong>Dificultad:</strong> {{ ucfirst($receta->dificultad) }}</p>
                    <p><strong>Raciones:</strong> {{ $receta->raciones }}</p>
                    <p><strong>Puntuación:</strong> {{ $receta->puntuacion }} ⭐ de {{ $receta->n_votos }} votos</p>
                </div>

                <div class="col-md-6 col-12">
                    @auth
                        @if ($receta->usuario_id !== Auth::id())
                            {{-- Mostrar formulario de voto si no eres el creador de la receta --}}
                            <h4>Vota esta receta</h4>
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            <form action="{{ route('recetas.votar', $receta) }}" method="POST" class="form-custom">
                                @csrf
                                <div class="row g-2 align-items-center">
                                    <div class="col-8">
                                        <label for="puntuacion" class="form-label">Tu puntuación (0 a 5):</label>
                                        <input type="number" step="0.1" min="0" max="5" name="puntuacion"
                                            id="puntuacion" class="form-control" required>
                                    </div>
                                    <div class="col-4 d-grid">
                                        <button type="submit" class="btn btn-custom mt-4">Enviar
                                            voto</button>
                                    </div>
                                </div>
                            </form>
                        @else
                            {{-- <div class="alert alert-info">
                                No puedes votar tu propia receta.
                            </div> --}}
                        @endif
                    @endauth
                </div>
            </div>

            <hr>

            <h5 class="px-2">Ingredientes:</h5>
            <ul class="list-group list-group-flush px-2">
                @foreach ($receta->ingredientes as $ingrediente)
                    <li class="list-group-item">
                        {{ $ingrediente->pivot->cantidad }} {{ $ingrediente->pivot->unidad }} de
                        {{ $ingrediente->nombre }}
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="d-flex flex-wrap justify-content-center gap-2 mb-4">
            <a href="{{ route('recetas.index') }}" class="btn btn-outline-secondary">Volver al listado</a>
            @auth
                @if ($receta->usuario_id === Auth::id())
                    <a href="{{ route('recetas.edit', $receta) }}" class="btn btn-warning">Editar receta</a>
                @endif
            @endauth
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Semana</label>
                                <select name="semana_id" class="form-select semana-select"
                                    data-receta="{{ $receta->id }}" required>
                                    <option value="">Selecciona una semana</option>
                                    @foreach ($semanas as $semana)
                                        <option value="{{ $semana->id }}" data-inicio="{{ $semana->inicio }}"
                                            data-fin="{{ $semana->fin }}">
                                            Semana del {{ \Carbon\Carbon::parse($semana->inicio)->format('d/m/Y') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Día</label>
                                <select name="dia_semana" class="form-select" id="dias-{{ $receta->id }}" required>
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
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
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
    </div>
@endsection
