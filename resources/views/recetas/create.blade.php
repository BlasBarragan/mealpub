@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4 text-center">Crear Nueva Receta</h1>

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
            <form action="{{ route('recetas.store') }}" method="POST" class="form-custom">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre de la receta</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="raciones" class="form-label">Raciones</label>
                    <input type="number" name="raciones" id="raciones" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="tipo_receta" class="form-label">Tipo de receta</label>
                    <select name="tipo_receta" id="tipo_receta" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <option value="entrante">Entrante</option>
                        <option value="aperitivo">Aperitivo</option>
                        <option value="plato_principal">Plato principal</option>
                        <option value="reposteria">Repostería</option>
                        <option value="cremas_y_sopas">Cremas y sopas</option>
                        <option value="arroces_y_pastas">Arroces y pastas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="dificultad" class="form-label">Dificultad</label>
                    <select name="dificultad" id="dificultad" class="form-select" required>
                        <option value="">Selecciona...</option>
                        <option value="facil">Fácil</option>
                        <option value="medio">Medio</option>
                        <option value="avanzado">Avanzado</option>
                    </select>
                </div>

                <hr>
                <h5 class="mb-3">Ingredientes</h5>
                <!-- Resumen visible fuera del modal -->
                <div id="tablaIngredientesResumen" class="d-none mt-3">
                    <h6>Ingredientes añadidos a la receta</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Ingrediente</th>
                                <th>Cantidad</th>
                                <th>Unidad</th>
                            </tr>
                        </thead>
                        <tbody id="listaIngredientesResumen">
                            <!-- Se rellenará con JavaScript -->
                        </tbody>
                    </table>
                </div>

                <div id="ingredientes-container">
                    <!-- Botón para abrir el modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modalIngredientes">
                        Añadir ingredientes
                    </button>

                    <!-- Lista oculta de ingredientes añadidos dentro del formulario -->
                    <div id="inputsIngredientes"></div>
                </div>

                <div class="d-flex justify-content-center gap-2 mt-4">
                    <button type="submit" class="btn btn-custom">Guardar receta</button>
                    <a href="{{ route('recetas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalIngredientes" tabindex="-1" aria-labelledby="modalIngredientesLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalIngredientesLabel">Gestionar ingredientes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- Filtro por tipo -->
                    <div class="row mb-3 align-items-end">
                        <div class="col-md-8">
                            <label for="tipoFiltro" class="form-label">Filtrar por tipo</label>
                            <select id="tipoFiltro" class="form-select">
                                <option value="">-- Todos --</option>
                                <!-- Opciones de tipo de ingrediente -->
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-secondary w-100" id="seleccionarIngrediente">Seleccionar</button>
                        </div>
                    </div>

                    <!-- Formulario para ingrediente seleccionado -->
                    <div id="formIngredienteSeleccionado" class="row mb-3 d-none">
                        <div class="col-md-4">
                            <select id="ingredienteNombre" class="form-select">
                                <option value="">Selecciona un ingrediente</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="number" id="ingredienteCantidad" class="form-control" placeholder="Cantidad">
                        </div>
                        <div class="col-md-3">
                            <input type="text" id="ingredienteUnidad" class="form-control" placeholder="Unidad">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success w-100" id="añadirIngrediente">Añadir</button>
                        </div>
                    </div>

                    <!-- Botón para nuevo ingrediente -->
                    <div class="mb-3">
                        <button class="btn btn-outline-primary" id="mostrarNuevoIngrediente">Crear nuevo
                            ingrediente</button>
                    </div>

                    <!-- Formulario nuevo ingrediente -->
                    <div id="formNuevoIngrediente" class="row g-2 mb-3 d-none">
                        <div class="col-md-3">
                            <input type="text" id="nuevoNombre" class="form-control" placeholder="Nombre">
                        </div>
                        <div class="col-md-2">
                            <input type="number" id="nuevoCantidad" class="form-control" placeholder="Cantidad">
                        </div>
                        <div class="col-md-2">
                            <input type="text" id="nuevoUnidad" class="form-control" placeholder="Unidad">
                        </div>
                        <div class="col-md-3">
                            <input list="tiposExistentes" id="nuevoTipo" class="form-control" placeholder="Tipo">
                            <datalist id="tiposExistentes">
                                <!-- tipos de ingredientes -->
                            </datalist>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-success w-100" id="crearYAñadir">Crear y
                                añadir</button>
                        </div>
                    </div>

                    <!-- Tabla de ingredientes añadidos -->
                    <div id="tablaIngredientesContainer" class="d-none">
                        <h6>Ingredientes añadidos</h6>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Ingrediente</th>
                                    <th>Cantidad</th>
                                    <th>Unidad</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody id="listaIngredientes">
                                <!-- Lista de ingredientes -->
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success"
                        onclick="guardarIngredientes(); document.body.classList.remove('modal-open'); document.querySelector('.modal-backdrop')?.remove();">Añadir
                        a receta</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="cancelarIngredientes()">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
        <script>
            const ingredientesDisponibles = @json($ingredientes);
            const tipos = [...new Set(ingredientesDisponibles.map(i => i.tipo))];

            let ingredientesAñadidos = [];
            let ingredienteSeleccionado = null;

            window.addEventListener('DOMContentLoaded', () => {
                // Insertamos en el select del filtro, los tipos existentes
                const tipoFiltro = document.getElementById('tipoFiltro');
                tipos.forEach(tipo => {
                    const option = document.createElement('option');
                    option.value = tipo;
                    option.textContent = tipo;
                    tipoFiltro.appendChild(option);

                    const dataOption = document.createElement('option');
                    dataOption.value = tipo;
                    document.getElementById('tiposExistentes').appendChild(dataOption);
                });
                // Boton seleccionar del filtro
                document.getElementById('seleccionarIngrediente').addEventListener('click', () => {
                    const tipo = tipoFiltro.value;
                    const filtrados = tipo ? ingredientesDisponibles.filter(i => i.tipo === tipo) :
                        ingredientesDisponibles;

                    const ingredienteSelect = document.getElementById('ingredienteNombre');
                    ingredienteSelect.innerHTML = '<option value="">Selecciona un ingrediente</option>';

                    filtrados.forEach(ing => {
                        const option = document.createElement('option');
                        option.value = ing.id;
                        option.textContent = ing.nombre;
                        ingredienteSelect.appendChild(option);
                    });
                    // Mostramos los inputs para añadir el ingrediente por tipo filtrado
                    document.getElementById('formIngredienteSeleccionado').classList.remove('d-none');

                });
                // Boton añadir ingrediente filtrado
                document.getElementById('añadirIngrediente').addEventListener('click', () => {
                    const ingredienteId = document.getElementById('ingredienteNombre').value;
                    const cantidad = document.getElementById('ingredienteCantidad').value;
                    const unidad = document.getElementById('ingredienteUnidad').value;
                    // Si falta algun dato del formulario
                    if (!ingredienteId || !cantidad || !unidad) return;

                    const ingredienteObj = ingredientesDisponibles.find(i => i.id == ingredienteId);
                    if (!ingredienteObj) return;

                    ingredientesAñadidos.push({
                        id: ingredienteObj.id,
                        nombre: ingredienteObj.nombre,
                        cantidad,
                        unidad,
                        nuevo: false
                    });

                    actualizarTabla();
                    document.getElementById('formIngredienteSeleccionado').classList.add('d-none');
                });

                document.getElementById('mostrarNuevoIngrediente').addEventListener('click', () => {
                    document.getElementById('formNuevoIngrediente').classList.toggle('d-none');
                });

                document.getElementById('crearYAñadir').addEventListener('click', () => {
                    const nombre = document.getElementById('nuevoNombre').value;
                    const cantidad = document.getElementById('nuevoCantidad').value;
                    const unidad = document.getElementById('nuevoUnidad').value;
                    const tipo = document.getElementById('nuevoTipo').value;
                    if (!nombre || !cantidad || !unidad || !tipo) return;

                    ingredientesAñadidos.push({
                        nombre,
                        cantidad,
                        unidad,
                        tipo,
                        nuevo: true
                    });
                    actualizarTabla();
                    document.getElementById('formNuevoIngrediente').classList.add('d-none');
                });
            });

            function actualizarTabla() {
                const contenedor = document.getElementById('tablaIngredientesContainer');
                const tbody = document.getElementById('listaIngredientes');
                tbody.innerHTML = '';
                ingredientesAñadidos.forEach((ing, index) => {
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
                    <td>${ing.nombre}</td>
                    <td>${ing.cantidad}</td>
                    <td>${ing.unidad}</td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="eliminarIngrediente(${index})">Eliminar</button></td>
                `;
                    tbody.appendChild(fila);
                });
                contenedor.classList.toggle('d-none', ingredientesAñadidos.length === 0);
            }

            function eliminarIngrediente(index) {
                ingredientesAñadidos.splice(index, 1);
                actualizarTabla();
            }

            function guardarIngredientes() {
                const inputsContainer = document.getElementById('inputsIngredientes');
                const resumenContainer = document.getElementById('tablaIngredientesResumen');
                const resumenBody = document.getElementById('listaIngredientesResumen');

                inputsContainer.innerHTML = '';
                resumenBody.innerHTML = '';

                ingredientesAñadidos.forEach((ing, i) => {
                    // Campos ocultos
                    if (ing.nuevo) {
                        inputsContainer.innerHTML += `
                <input type="hidden" name="ingredientes_nuevos[${i}][nuevo_nombre]" value="${ing.nombre}">
                <input type="hidden" name="ingredientes_nuevos[${i}][cantidad]" value="${ing.cantidad}">
                <input type="hidden" name="ingredientes_nuevos[${i}][unidad]" value="${ing.unidad}">
                <input type="hidden" name="ingredientes_nuevos[${i}][nuevo_tipo]" value="${ing.tipo}">
            `;
                    } else {
                        inputsContainer.innerHTML += `
                <input type="hidden" name="ingredientes_existentes[${i}][id]" value="${ing.id}">
                <input type="hidden" name="ingredientes_existentes[${i}][cantidad]" value="${ing.cantidad}">
                <input type="hidden" name="ingredientes_existentes[${i}][unidad]" value="${ing.unidad}">
            `;
                    }

                    // Tabla resumen fuera del modal
                    const fila = document.createElement('tr');
                    fila.innerHTML = `
            <td>${ing.nombre}</td>
            <td>${ing.cantidad}</td>
            <td>${ing.unidad}</td>
        `;
                    resumenBody.appendChild(fila);
                });

                resumenContainer.classList.toggle('d-none', ingredientesAñadidos.length === 0);

                const modal = bootstrap.Modal.getInstance(document.getElementById('modalIngredientes'));
                modal.hide();
            }


            function cancelarIngredientes() {
                ingredientesAñadidos = [];
                actualizarTabla();
                document.getElementById('inputsIngredientes').innerHTML = '';
            }

            document.getElementById('modalIngredientes').addEventListener('hidden.bs.modal', function() {
                document.body.style.overflow = '';
                document.body.style.paddingRight = '';
                document.body.classList.remove('modal-open');
                document.querySelector('.modal-backdrop')?.remove();
            });
        </script>
    @endpush
@endsection
