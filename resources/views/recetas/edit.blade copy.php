@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Editar Receta: {{ $receta->nombre }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card card-custom p-4">
            <form action="{{ route('recetas.update', $receta) }}" method="POST" class="form-custom">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la receta</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $receta->nombre }}"
                        required>
                </div>

                <div class="mb-3">
                    <label for="raciones" class="form-label">Raciones</label>
                    <input type="number" name="raciones" id="raciones" class="form-control"
                        value="{{ $receta->raciones }}" required>
                </div>

                <div class="mb-3">
                    <label for="tipo_receta" class="form-label">Tipo de receta</label>
                    <select name="tipo_receta" class="form-select" required>
                        @foreach (['entrante', 'aperitivo', 'plato_principal', 'reposteria', 'cremas_y_sopas', 'arroces_y_pastas'] as $tipo)
                            <option value="{{ $tipo }}" {{ $receta->tipo_receta === $tipo ? 'selected' : '' }}>
                                {{ ucfirst(str_replace('_', ' ', $tipo)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dificultad" class="form-label">Dificultad</label>
                    <select name="dificultad" class="form-select" required>
                        @foreach (['facil', 'medio', 'avanzado'] as $dif)
                            <option value="{{ $dif }}" {{ $receta->dificultad === $dif ? 'selected' : '' }}>
                                {{ ucfirst($dif) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <hr>
                <h5 class="mb-3">Ingredientes existentes</h5>
                @foreach ($receta->ingredientes as $i => $ingrediente)
                    <div class="row mb-3 align-items-end">
                        <input type="hidden" name="ingredientes_existentes[{{ $i }}][id]"
                            value="{{ $ingrediente->id }}">
                        <div class="col-md-4">
                            <select class="form-select" disabled>
                                <option selected>{{ $ingrediente->nombre }}</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" step="0.01"
                                name="ingredientes_existentes[{{ $i }}][cantidad]" class="form-control"
                                value="{{ $ingrediente->pivot->cantidad }}">
                        </div>
                        <div class="col-md-3">
                            <input type="text" name="ingredientes_existentes[{{ $i }}][unidad]"
                                class="form-control" value="{{ $ingrediente->pivot->unidad }}">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger eliminar-ingrediente"
                                data-id="{{ $ingrediente->id }}">Eliminar</button>
                        </div>
                    </div>
                @endforeach

                <input type="hidden" name="ingredientes_eliminados" id="ingredientes_eliminados">

                <hr>
                <h5 class="mb-3">Añadir nuevo ingrediente</h5>
                <div class="row g-2 align-items-end mb-3">
                    <div class="col-md-3">
                        <label class="form-label">Nombre</label>
                        <input type="text" id="nuevo_nombre" class="form-control" oninput="buscarIngrediente()">
                        <div id="sugerencias" class="list-group position-absolute z-3"></div>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Cantidad</label>
                        <input type="number" step="0.01" id="nuevo_cantidad" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Unidad (ej. g, vaso, cucharada)</label>
                        <input type="text" id="nuevo_unidad" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Tipo</label>
                        <select id="nuevo_tipo" class="form-select">
                            <option value="">Selecciona tipo</option>
                            @foreach ($tiposIngrediente as $tipo)
                                <option value="{{ $tipo }}">{{ ucfirst($tipo) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-success" onclick="agregarNuevoIngrediente()">Añadir</button>
                    </div>
                </div>

                <div id="ingredientes-nuevos-container"></div>

                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="submit" class="btn btn-custom">Actualizar receta</button>
                    <a href="{{ route('recetas.mis') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        let nuevos = 0;
        const eliminados = [];

        function buscarIngrediente() {
            const texto = document.getElementById('nuevo_nombre').value.toLowerCase();
            const sugerencias = @json($ingredientes->pluck('nombre'));
            let resultados = sugerencias.filter(n => n.toLowerCase().includes(texto));
            let contenedor = document.getElementById('sugerencias');
            contenedor.innerHTML = '';
            if (texto && resultados.length) {
                resultados.forEach(nombre => {
                    contenedor.innerHTML +=
                        `<button type="button" class="list-group-item list-group-item-action" onclick="seleccionarIngrediente('${nombre}')">${nombre}</button>`;
                });
            }
        }

        function seleccionarIngrediente(nombre) {
            document.getElementById('nuevo_nombre').value = nombre;
            document.getElementById('sugerencias').innerHTML = '';
        }

        function agregarNuevoIngrediente() {
            const nombre = document.getElementById('nuevo_nombre').value;
            const cantidad = document.getElementById('nuevo_cantidad').value;
            const unidad = document.getElementById('nuevo_unidad').value;
            const tipo = document.getElementById('nuevo_tipo').value;

            if (!nombre || !cantidad || !unidad || !tipo) {
                alert('Completa todos los campos del nuevo ingrediente incluyendo el tipo.');
                return;
            }

            const contenedor = document.getElementById('ingredientes-nuevos-container');
            contenedor.innerHTML += `
            <input type="hidden" name="ingredientes_nuevos[${nuevos}][nuevo_nombre]" value="${nombre}">
            <input type="hidden" name="ingredientes_nuevos[${nuevos}][cantidad]" value="${cantidad}">
            <input type="hidden" name="ingredientes_nuevos[${nuevos}][unidad]" value="${unidad}">
            <input type="hidden" name="ingredientes_nuevos[${nuevos}][nuevo_tipo]" value="${tipo}">
            <div class="alert alert-info d-flex justify-content-between align-items-center">
                <span>Nuevo ingrediente: ${cantidad} ${unidad} de ${nombre} (${tipo})</span>
                <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
            </div>
        `;
            nuevos++;
            document.getElementById('nuevo_nombre').value = '';
            document.getElementById('nuevo_cantidad').value = '';
            document.getElementById('nuevo_unidad').value = '';
            document.getElementById('nuevo_tipo').value = '';
            document.getElementById('sugerencias').innerHTML = '';
        }

        // Eliminar ingrediente existente
        document.querySelectorAll('.eliminar-ingrediente').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                eliminados.push(id);
                document.getElementById('ingredientes_eliminados').value = eliminados.join(',');
                this.closest('.row').remove();
            });
        });
    </script>
@endsection
