<?php

namespace App\Http\Controllers;

use App\Models\Semana;
use App\Models\Receta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // libreria de PHP para trabajar fechas de forma mas sencilla

class SemanaController extends Controller
{
    // Muestra todas las semanas creadas por el usuario
    public function index()
    {
        $semanas = Semana::where('usuario_id', Auth::id())->orderBy('inicio', 'desc')->get();
        return view('semanas.index', compact('semanas'));
    }

    // Formulario de planificacion de semanas
    public function planificar(Request $request)
    {
        // Obtenenemos recetas favoritas
        $favoritas = Auth::user()->recetasFavoritas;
        // Obtenemos recetas creadas por el usuario
        $propias = Receta::where('usuario_id', Auth::id())->get();

        $recetas = $propias->merge($favoritas)->unique('id')->sortBy('nombre')->values()->map(function ($r) {
            return ['id' => $r->id, 'nombre' => $r->nombre];
        });

        return view('semanas.planificar', compact('recetas'));
    }

    // Validamos fechas
    public function validarFechas(Request $request)
    {
        $request->validate([
            'inicio' => 'required|date',
            'fin' => 'required|date|after_or_equal:inicio',
        ]);

        // Validamos que la semana no tenga mas de 7 dias
        $inicio = Carbon::parse($request->inicio);
        $fin = Carbon::parse($request->fin);

        if ($inicio->diffInDays($fin) >= 7) {
            return back()->withErrors([
                'fin' => 'La semana no puede tener más de 7 días.',
            ])->withInput();
        }

        // Verificamos si ya existe la semana
        $existe = Semana::where('usuario_id', Auth::id())
            ->where('inicio', $request->inicio)
            ->where('fin', $request->fin)
            ->exists();
        // Si existe, volvemos al formulario de fechas con error
        if ($existe) {
            return back()->withErrors([
                'inicio' => 'Ya existe una semana con estas fechas.',
                'fin' => 'Ya existe una semana con estas fechas.',
            ])->withInput();
        }

        // Generamos los dias entre inicio y fin
        $dias = collect();
        $fecha = Carbon::parse($request->inicio);
        $fin = Carbon::parse($request->fin);

        while ($fecha->lte($fin)) {
            $dias->push([
                'fecha' => $fecha->toDateString(),
                'nombre' => $fecha->locale('es')->isoFormat('dddd'),
            ]);
            $fecha->addDay();
        }

        // Obtenemos recetas disponibles
        $favoritas = Auth::user()->recetasFavoritas;
        $propias = Receta::where('usuario_id', Auth::id())->get();
        $recetas = $propias->merge($favoritas)->unique('id')->sortBy('nombre');

        return view('semanas.planificar', [
            'recetas' => $recetas,
            'dias' => $dias,
            'inicio' => $request->inicio,
            'fin' => $request->fin,
        ]);
    }

    // Guardar la semana creada
    public function store(Request $request)
    {   // validamos formulario
        $data = $request->validate([
            'inicio' => 'required|date',
            'fin' => 'required|date|after_or_equal:inicio', // fecha_fin siempre igual o despues de inicio
            'dias' => 'required|array',
        ]);

        $inicio = Carbon::parse($data['inicio']);
        $fin = Carbon::parse($data['fin']);

        if ($inicio->diffInDays($fin) >= 7) {
            return back()->withErrors([
                'fin' => 'La semana no puede tener más de 7 días.',
            ])->withInput();
        }

        // Verificar si ya existe una semana con esas fechas para el mismo usuario
        $existe = Semana::where('usuario_id', Auth::id())
            ->where('inicio', $data['inicio'])
            ->where('fin', $data['fin'])
            ->exists();

        if ($existe) {
            return back()->withErrors([
                'inicio' => 'Ya existe una semana con estas fechas.',
                'fin' => 'Ya existe una semana con estas fechas.',
            ])->withInput();
        }

        $semana = Semana::create([
            'usuario_id' => Auth::id(),
            'inicio' => $data['inicio'],
            'fin' => $data['fin'],
        ]);
        // por cada dia de la semana creada
        foreach ($data['dias'] as $fecha => $momentos) {
            $semana->recetasSemana()->create([
                'dia_semana' => Carbon::parse($fecha)->locale('es')->isoFormat('dddd'),
                // los campos para las recetas se pueden guardar vacios
                'desayuno_receta_id' => $momentos['desayuno'] ?? null,
                'comida_receta_id' => $momentos['comida'] ?? null,
                'merienda_receta_id' => $momentos['merienda'] ?? null,
                'cena_receta_id' => $momentos['cena'] ?? null,
            ]);
        }

        return redirect()->route('semanas.index')->with('success', 'Semana planificada con éxito.');
    }

    // Creamos semana vacia
    public function preparar(Request $request)
    {
        $data = $request->validate([
            'inicio' => 'required|date',
            'fin' => 'required|date|after_or_equal:inicio',
        ]);

        // Verificamos si ya existe la semana
        $existe = Semana::where('usuario_id', Auth::id())
            ->where('inicio', $data['inicio'])
            ->where('fin', $data['fin'])
            ->exists();

        // Si existe, (INSERT de error), volvemos al formulario de fechas con error
        if ($existe) {
            return back()->withErrors([
                'inicio' => 'Ya existe una semana con estas fechas.',
                'fin' => 'Ya existe una semana con estas fechas.',
            ])->withInput();
        }


        // Si no existe, Creamos semana vacía (sin recetas aún) (hacemos INSERT a BD)
        $semana = Semana::create([
            'usuario_id' => Auth::id(),
            'inicio' => $data['inicio'],
            'fin' => $data['fin'],
        ]);
        // redirigimos al formulario de edicion de semana
        return redirect()->route('semanas.edit', $semana);
    }


    // Mostrar detalle de una semana
    public function show(Semana $semana)
    {
        if ($semana->usuario_id !== Auth::id()) {
            abort(403);
        }

        $semana->load(['recetasSemana.desayuno', 'recetasSemana.comida', 'recetasSemana.merienda', 'recetasSemana.cena']);

        return view('semanas.show', compact('semana'));
    }

    // Eliminar una semana
    public function destroy(Semana $semana)
    {
        if ($semana->usuario_id !== Auth::id()) {
            abort(403);
        }

        $semana->recetasSemana()->delete();
        $semana->delete();

        return redirect()->route('semanas.index')->with('success', 'Semana eliminada correctamente.');
    }

    // Duplicar una semana (usar una semana ya creada como plantilla)
    public function duplicar(Semana $semana)
    {
        if ($semana->usuario_id !== Auth::id()) {
            abort(403);
        }

        $nuevaSemana = Semana::create([
            'usuario_id' => $semana->usuario_id,
            'inicio' => now()->startOfWeek(),
            'fin' => now()->startOfWeek()->addDays(6), // 6 dias despues de la fecha_ini
        ]);

        foreach ($semana->recetasSemana as $dia) {
            $nuevaSemana->recetasSemana()->create([
                'dia_semana' => $dia->dia_semana,
                'desayuno_receta_id' => $dia->desayuno_receta_id,
                'comida_receta_id' => $dia->comida_receta_id,
                'merienda_receta_id' => $dia->merienda_receta_id,
                'cena_receta_id' => $dia->cena_receta_id,
            ]);
        }

        return redirect()->route('semanas.index')->with('success', 'Semana duplicada correctamente.');
    }
    // Duplicar con fecha ( al haber cambiado la restriccion de fechas, no se puede duplicar una semana con fechas ya ocupadas, por lo que mostramos modal para elegir fecha de inicio antes de copiar la semana)
    public function duplicarConFecha(Request $request, Semana $semana)
    {
        // VAlidamos formulario
        $request->validate([
            'inicio' => 'required|date',
        ]);

        $nuevaInicio = Carbon::parse($request->inicio);
        $originalInicio = Carbon::parse($semana->inicio);
        $originalFin = Carbon::parse($semana->fin);

        $diasDuracion = $originalInicio->diffInDays($originalFin);
        $nuevaFin = $nuevaInicio->copy()->addDays($diasDuracion);

        // Validamos que la semana no tenga mas de 7 dias
        if ($diasDuracion > 6) {
            return back()->withErrors([
                'inicio' => 'La semana duplicada no puede superar los 7 días.',
            ])->withInput();
        }
        // Verificamos si ya existe la semana para evitar semanas duplicadas
        $existe = Semana::where('usuario_id', Auth::id())
            ->where('inicio', $nuevaInicio->toDateString())
            ->where('fin', $nuevaFin->toDateString())
            ->exists();
        // Si existe, (INSERT de error), volvemos al formulario de fechas con error
        if ($existe) {
            return back()
                ->withErrors([
                    'inicio' => 'Ya existe una semana con ese rango de fechas.',
                    'duplicar_error' => 'Ya existe una semana con ese rango de fechas.'
                ])->withInput($request->only('inicio', 'desde_modal'));
        }

        // Creamos la neva semana
        $nuevaSemana = Semana::create([
            'usuario_id' => Auth::id(),
            'inicio' => $nuevaInicio->toDateString(),
            'fin' => $nuevaFin->toDateString(),
        ]);

        $diasOriginal = collect($semana->recetasSemana)->sortBy(function ($d) use ($originalInicio) {
            return Carbon::parse($d->created_at)->diffInDays($originalInicio);
        })->values();
        // Copiamos los dias y momentos de la semana original a la nueva semana
        foreach ($diasOriginal as $i => $dia) {
            $fecha = $nuevaInicio->copy()->addDays($i);
            $nuevaSemana->recetasSemana()->create([
                'dia_semana' => $fecha->locale('es')->isoFormat('dddd'),
                'desayuno_receta_id' => $dia->desayuno_receta_id,
                'comida_receta_id' => $dia->comida_receta_id,
                'merienda_receta_id' => $dia->merienda_receta_id,
                'cena_receta_id' => $dia->cena_receta_id,
            ]);
        }

        return redirect()->route('semanas.show', $nuevaSemana)->with('success', 'Semana duplicada correctamente.');
    }

    // Editar una semana
    public function edit(Semana $semana)
    {
        if ($semana->usuario_id !== Auth::id()) {
            abort(403);
        }

        // Obtenenemos recetas favoritas del usuario
        $favoritas = Auth::user()->recetasFavoritas;
        // Obtenemos recetas propias del usuario
        $propias = Receta::where('usuario_id', Auth::id())->get();

        $recetas = $propias->merge($favoritas)->unique('id')->sortBy('nombre');

        return view('semanas.edit', compact('semana', 'recetas'));
    }

    // Actualizar una semana
    public function update(Request $request, Semana $semana)
    {
        if ($semana->usuario_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'dias' => 'required|array',
        ]);
        // Buscamos el id y actualizamos la receta por la que se muestre en el formulario de edicion
        foreach ($data['dias'] as $id => $momentos) {
            $dia = $semana->recetasSemana()->find($id);

            if ($dia) {
                $dia->update([
                    'desayuno_receta_id' => $momentos['desayuno'] ?? null,
                    'comida_receta_id' => $momentos['comida'] ?? null,
                    'merienda_receta_id' => $momentos['merienda'] ?? null,
                    'cena_receta_id' => $momentos['cena'] ?? null,
                ]);
            }
        }
        // volvemos al detalle de la semana con mensaje de confirmacion
        return redirect()->route('semanas.show', $semana)->with('success', 'Semana actualizada correctamente.');
    }
}
