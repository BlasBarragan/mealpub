@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Nombre de la semana --}}
        <h1 class="mb-4">Editar semana del {{ $semana->inicio }} al {{ $semana->fin }}</h1>

        <form method="POST" action="{{ route('semanas.update', $semana) }}">
            @csrf
            @method('PUT')

            @php
                $dias = $semana->recetasSemana->groupBy('dia_semana');
            @endphp
            {{-- Aviso de recetas faltantes (si esta seleccionado Ninguna, no hay ID recetasSemana en BD) --}}
            @foreach ($semana->recetasSemana as $dia)
                @php
                    $faltantes = [];
                    foreach (['desayuno', 'comida', 'merienda', 'cena'] as $m) {
                        if (empty($dia->{"{$m}_receta_id"})) {
                            $faltantes[] = ucfirst($m);
                        }
                    }
                @endphp
                <div class="card mb-4">
                    <div class="card-header text-capitalize d-flex justify-content-between align-items-center">
                        <strong>{{ $dia->dia_semana }}</strong>
                        {{-- Muestra aviso faltantes --}}
                        @if ($faltantes)
                            <span class="badge bg-warning text-dark">Faltan: {{ implode(', ', $faltantes) }}</span>
                        @endif
                    </div>
                    <div class="card-body row">
                        {{-- Selects de cada momento y cada dia --}}
                        @foreach (['desayuno', 'comida', 'merienda', 'cena'] as $momento)
                            <div class="col-md-3 mb-3">
                                <label class="form-label text-capitalize">{{ $momento }}</label>
                                <input type="hidden" name="dias[{{ $dia->id }}][id]" value="{{ $dia->id }}">
                                <select name="dias[{{ $dia->id }}][{{ $momento }}]" class="form-select">
                                    <option value="">-- Ninguna --</option>
                                    @foreach ($recetas as $receta)
                                        <option value="{{ $receta->id }}"
                                            @if ($dia->{"{$momento}_receta_id"} == $receta->id) selected @endif>
                                            {{ $receta->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            {{-- Boton actualizar --}}
            <button type="submit" class="btn btn-success">Actualizar semana</button>
            {{-- Boton cancelar --}}
            <a href="{{ route('semanas.show', $semana) }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
@endsection
