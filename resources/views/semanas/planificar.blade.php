@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Planificar semana</h1>

        {{-- Formulario inicial para validar fechas --}}
        <form method="POST" action="{{ route('semanas.validar') }}">
            @csrf

            <div class="row g-2 align-items-end mb-4">
                <div class="col-md-5">
                    <label for="inicio" class="form-label">Fecha de inicio</label>
                    <input type="date" name="inicio" class="form-control @error('inicio') is-invalid @enderror"
                        value="{{ old('inicio', $inicio ?? '') }}" required>
                    @error('inicio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-5">
                    <label for="fin" class="form-label">Fecha de fin</label>
                    <input type="date" name="fin" class="form-control @error('fin') is-invalid @enderror"
                        value="{{ old('fin', $fin ?? '') }}" required>
                    @error('fin')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">Validar fechas</button>
                </div>
            </div>
        </form>

        {{-- Si las fechas fueron son validas, generamos los dias --}}
        @if (!empty($dias))
            <form method="POST" action="{{ route('semanas.store') }}">
                @csrf
                <input type="hidden" name="inicio" value="{{ $inicio }}">
                <input type="hidden" name="fin" value="{{ $fin }}">

                @foreach ($dias as $dia)
                    <div class="card mb-4">
                        <div class="card-header text-capitalize">
                            <strong>{{ $dia['nombre'] }} - {{ $dia['fecha'] }}</strong>
                        </div>
                        <div class="card-body row">
                            @foreach (['desayuno', 'comida', 'merienda', 'cena'] as $momento)
                                <div class="col-md-3 mb-3">
                                    <label class="form-label text-capitalize">{{ $momento }}</label>
                                    <select name="dias[{{ $dia['fecha'] }}][{{ $momento }}]" class="form-select">
                                        <option value="">-- Ninguna --</option>
                                        @foreach ($recetas as $receta)
                                            <option value="{{ $receta->id }}">{{ $receta->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <button type="submit" class="btn btn-primary">Guardar semana</button>
                <a href="{{ route('semanas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        @endif
    </div>

    {{-- script obsoleto por haber cambiado la forma en que creo las semanas para verificar si existe ya una semana con esas fechas y evitar duplicados --}}
    {{-- <script>
        // Generamos un formulario para seleccionar las recetas en cada momento de cada dia al seleccionar la fecha fin (siempre que cumpla los requisitos de max 7dias y fin mayor o igual que inicio)
        const recetas = @json($recetas);

        const inicioInput = document.getElementById('inicio');
        const finInput = document.getElementById('fin');
        const guardarBtn = document.getElementById('guardarBtn');

        inicioInput.addEventListener('change', generarDias);
        finInput.addEventListener('change', generarDias);

        function generarDias() {
            const inicio = inicioInput.value;
            const fin = finInput.value;
            const output = document.getElementById('planificacion-dias');
            const mensaje = document.getElementById('mensaje-error');

            output.innerHTML = '';
            mensaje.innerHTML = '';
            guardarBtn.disabled = true;

            if (!inicio || !fin) {
                mensaje.innerHTML = '<div class="alert alert-warning">Selecciona ambas fechas para generar los días.</div>';
                return;
            }

            const fechaInicio = new Date(inicio);
            const fechaFin = new Date(fin);
            // Calculamos el numero de dias entre fechas
            const diff = (fechaFin - fechaInicio) / (1000 * 60 * 60 * 24);
            // Error si no cumple requisitos
            if (diff < 0 || diff > 6) {
                mensaje.innerHTML =
                    '<div class="alert alert-danger">La semana debe tener máximo 7 días y fin no puede ser anterior al inicio.</div>';
                return;
            }

            // Por cada fecha, obtenemos el nombre del dia que es
            const dias = ['domingo', 'lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado'];

            for (let i = 0; i <= diff; i++) {
                const fecha = new Date(fechaInicio);
                fecha.setDate(fecha.getDate() + i);
                const nombreDia = dias[fecha.getDay()];
                const fechaStr = fecha.toISOString().split('T')[0];
                const card = document.createElement('div');

                card.classList.add('card', 'mb-4');
                // añadimos al div
                card.innerHTML = `
                <div class="card-header text-capitalize d-flex justify-content-between align-items-center">
                    <strong>${nombreDia}</strong>
                    <span class="faltantes badge bg-warning text-dark d-none">Faltan campos</span>
                </div>
                <div class="card-body row">
                    ${['desayuno', 'comida', 'merienda', 'cena'].map(momento => `
                                                                            <div class="col-md-3 mb-3">
                                                                                <label class="form-label text-capitalize">${momento}</label>
                                                                                <select name="dias[${fechaStr}][${momento}]" class="form-select" onchange="verificarFaltantes(this)">
                                                                                    <option value="">-- Ninguna --</option>
                                                                                    ${recetas.map(r => `<option value="${r.id}">${r.nombre}</option>`).join('')}
                                                                                </select>
                                                                            </div>
                                                                        `).join('')}
                </div>
            `;
                // añadimos div al contenedor
                output.appendChild(card);
            }

            guardarBtn.disabled = false;
            verificarFaltantes();
        }

        // Comprobamos si hay selects vacios y los mostramos en el aviso (badge)
        function verificarFaltantes() {
            const cards = document.querySelectorAll('#planificacion-dias .card');
            cards.forEach(card => {
                const selects = card.querySelectorAll('select');
                const badge = card.querySelector('.faltantes');
                const vacios = Array.from(selects).filter(s => s.value === "");
                badge.classList.toggle('d-none', vacios.length === 0);
            });
        }
    </script> --}}
@endsection
