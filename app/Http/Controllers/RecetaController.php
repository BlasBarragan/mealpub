<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use App\Models\Ingrediente;
use App\Models\Semana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Ui\Presets\React;

class RecetaController extends Controller
{
    // Muestra una lista de todas las recetas teniendo en cuenta los parametros en el filtro y la busqueda de la pagina
    public function index(Request $request)
    {
        $query = Receta::with('ingredientes');

        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }

        if ($request->filled('tipo_receta')) {
            $query->where('tipo_receta', $request->tipo_receta);
        }

        if ($request->filled('dificultad')) {
            $query->where('dificultad', $request->dificultad);
        }

        if ($request->filled('puntuacion_min')) {
            $query->where('puntuacion', '>=', $request->puntuacion_min);
        }

        $recetas = $query->get();
        $semanas = Semana::where('usuario_id', Auth::id())->get();

        return view('recetas.index', compact('recetas', 'semanas'));
    }

    // Muestra el formulario para crear una nueva receta
    public function create()
    {
        $ingredientes = Ingrediente::all();
        $tiposIngrediente = ['fruta', 'verdura', 'carne', 'pescado', 'ave', 'especia', 'lacteo', 'cereal', 'legumbre'];
        return view('recetas.create', compact('ingredientes', 'tiposIngrediente'));
    }

    // Guarda una nueva receta y sus ingredientes asociados
    public function store(Request $request)
    {   // Validamos los datos del formulario
        $data = $request->validate([
            'nombre' => 'required|string|max:45',
            'raciones' => 'required|integer',
            'tipo_receta' => 'required|in:entrante,aperitivo,plato_principal,reposteria,cremas_y_sopas,arroces_y_pastas',
            'dificultad' => 'required|in:facil,medio,avanzado',
        ]);
        // Añadimos el id de usuario e inicializamos a 0 puntuacion y n_votos Y creamos el registro en la BD
        $receta = Receta::create(array_merge($data, [
            'usuario_id' => Auth::id(),
            'puntuacion' => 0,
            'n_votos' => 0
        ]));

        // Añadimos la receta a las favoritas por defecto
        // $receta->usuariosFavoritos()->attach(Auth::id()); #Deprecado al añadir vista mis recetas

        // Por cada ingradiente en la receta que ya exista en la BD
        if ($request->filled('ingredientes_existentes')) {
            foreach ($request->ingredientes_existentes as $item) {
                if (!empty($item['id']) && !empty($item['cantidad']) && !empty($item['unidad'])) {
                    $receta->ingredientes()->attach($item['id'], [
                        'cantidad' => $item['cantidad'],
                        'unidad' => $item['unidad']
                    ]);
                }
            }
        }

        // Por cada ingrediente nuevo en la receta que no exista ya en la BD
        if ($request->filled('ingredientes_nuevos')) {
            foreach ($request->ingredientes_nuevos as $item) {
                if (!empty($item['nuevo_nombre']) && !empty($item['cantidad']) && !empty($item['unidad']) && !empty($item['nuevo_tipo'])) {
                    $existing = Ingrediente::where('nombre', $item['nuevo_nombre'])->first();
                    $ingredienteId = $existing ? $existing->id : Ingrediente::create([
                        'nombre' => $item['nuevo_nombre'],
                        'tipo' => $item['nuevo_tipo']
                    ])->id;

                    $receta->ingredientes()->attach($ingredienteId, [
                        'cantidad' => $item['cantidad'],
                        'unidad' => $item['unidad']
                    ]);
                }
            }
        }
        // volvemos al indice con un mensaje de confirmacion
        return redirect(url()->previous())->with('success', 'Receta creada');
    }

    // Muestra las recetas de un usuario
    public function misRecetas()
    {
        $recetas = Receta::where('usuario_id', Auth::id())->orderBy('created_at', 'desc')->get();
        $semanas = Semana::where('usuario_id', Auth::id())->orderBy('inicio', 'desc')->get();

        return view('recetas.mis', compact('recetas', 'semanas'));
    }


    // Muestra el detalle de una receta
    public function show(Receta $receta)
    {
        $receta->load('ingredientes');
        $semanas = Semana::where('usuario_id', Auth::id())->orderByDesc('inicio')->get();

        return view('recetas.show', compact('receta', 'semanas'));
    }

    // Formulario para editar una receta existente
    public function edit(Receta $receta)
    {   // Las recetas solo son editable por el usuario que las ha creado
        if ($receta->usuario_id !== Auth::id()) {
            abort(403);
        }
        $ingredientes = Ingrediente::all();
        $receta->load('ingredientes');
        $tiposIngrediente = ['fruta', 'verdura', 'carne', 'pescado', 'ave', 'especia', 'lacteo', 'cereal', 'legumbre'];
        return view('recetas.edit', compact('receta', 'ingredientes', 'tiposIngrediente'));
    }

    // Actualiza los ingredientes y datos generales de la receta (excepto puntuación)
    public function update(Request $request, Receta $receta)
    {
        if ($receta->usuario_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validate([
            'nombre' => 'required|string|max:45',
            'raciones' => 'required|integer',
            'tipo_receta' => 'required|in:entrante,aperitivo,plato_principal,reposteria,cremas_y_sopas,arroces_y_pastas',
            'dificultad' => 'required|in:facil,medio,avanzado',
        ]);

        $receta->update($data);

        // Detach explícito solo para ingredientes marcados como eliminados
        $eliminados = array_filter(explode(',', $request->ingredientes_eliminados));
        $receta->ingredientes()->detach($eliminados);

        // Actualizar o mantener ingredientes existentes
        if ($request->has('ingredientes_existentes')) {
            foreach ($request->ingredientes_existentes as $item) {
                if (!empty($item['id']) && !empty($item['cantidad']) && !empty($item['unidad'])) {
                    if ($receta->ingredientes->contains($item['id'])) {
                        $receta->ingredientes()->updateExistingPivot($item['id'], [
                            'cantidad' => $item['cantidad'],
                            'unidad' => $item['unidad']
                        ]);
                    } else {
                        $receta->ingredientes()->attach($item['id'], [
                            'cantidad' => $item['cantidad'],
                            'unidad' => $item['unidad']
                        ]);
                    }
                }
            }
        }

        // Añadir nuevos ingredientes
        if ($request->has('ingredientes_nuevos')) {
            foreach ($request->ingredientes_nuevos as $item) {
                if (!empty($item['nuevo_nombre']) && !empty($item['cantidad']) && !empty($item['unidad']) && !empty($item['nuevo_tipo'])) {
                    $existing = Ingrediente::where('nombre', $item['nuevo_nombre'])->first();
                    $ingredienteId = $existing ? $existing->id : Ingrediente::create([
                        'nombre' => $item['nuevo_nombre'],
                        'tipo' => $item['nuevo_tipo']
                    ])->id;

                    // Solo lo añadimos si no estaba ya asignado
                    if (!$receta->ingredientes->contains($ingredienteId)) {
                        $receta->ingredientes()->attach($ingredienteId, [
                            'cantidad' => $item['cantidad'],
                            'unidad' => $item['unidad']
                        ]);
                    }
                }
            }
        }

        return redirect(url()->previous())->with('success', 'Receta actualizada correctamente.');
    }


    // Elimina una receta de la base de datos
    public function destroy(Request $request, Receta $receta)
    {
        // Las recetas solo las puede eliminar el usuario que las ha creado
        if ($receta->usuario_id !== Auth::id()) {
            abort(403);
        }

        // Obtenemos los ID de los ingredientes que hay en la receta
        $ingredientesIds = $receta->ingredientes()->pluck('ingredientes.id')->toArray();

        // Separo ingredientes de la receta
        $receta->ingredientes()->detach();

        try {
            // Intentamos eliminar la receta
            $receta->delete();

            // Revisamos los ingredientes para borrar de la BD los que ya no estan asociados a ninguna receta
            foreach ($ingredientesIds as $id) {
                $ingrediente = \App\Models\Ingrediente::find($id);
                if ($ingrediente && $ingrediente->recetas()->count() === 0) {
                    $ingrediente->delete();
                }
            }

            return $this->redirigirDespuesDeEliminar($request, 'success', 'Receta e ingredientes no usados eliminados.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                return $this->redirigirDespuesDeEliminar($request, 'error', 'No puedes eliminar esta receta porque está siendo usada en una semana.');
            }
            throw $e;
        }
    }

    private function redirigirDespuesDeEliminar(Request $request, $tipo, $mensaje)
    {
        $origen = $request->input('origen');

        return match ($origen) {
            'mis' => redirect()->route('recetas.mis')->with($tipo, $mensaje),
            'index' => redirect()->route('recetas.index')->with($tipo, $mensaje),
            default => redirect()->back()->with($tipo, $mensaje),
        };
    }


    // Forulacio de voto de una receta
    public function votar(Request $request, Receta $receta)
    {
        // No se permite votar tu propia receta
        if ($receta->usuario_id === Auth::id()) {
            return redirect()->route('recetas.show', $receta)
                ->with('error', 'No puedes votar tus propias recetas.');
        }

        // Validamos el formulario
        $request->validate([
            'puntuacion' => 'required|numeric|min:0|max:5',
        ]);

        // Calculamos la media con el n_votos y la puntuacion de la receta
        $nuevaPuntuacion = (($receta->puntuacion * $receta->n_votos) + $request->puntuacion) / ($receta->n_votos + 1);
        $receta->puntuacion = $nuevaPuntuacion;
        $receta->n_votos += 1;
        $receta->save();

        return redirect()->route('recetas.show', $receta)->with('success', '¡Gracias por votar!');
    }
}
