<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Receta;
use App\Models\Semana;

class FavoritoController extends Controller
{
    // Boton añadir/quitar favorita
    public function toggle(Receta $receta)
    {
        $usuario = Auth::user();
        // Si la receta ya esta en favoritas, la quitamos
        if ($usuario->recetasFavoritas()->where('receta_id', $receta->id)->exists()) {
            $usuario->recetasFavoritas()->detach($receta->id);
            $mensaje = 'Receta eliminada de favoritas';
        } else { // si no esta, la añadimos
            $usuario->recetasFavoritas()->attach($receta->id);
            $mensaje = 'Receta añadida a favoritas';
        }
        // Volvemos a la pagina con mensaje de confirmacion
        return redirect()->back()->with('success', $mensaje);
    }

    // Mostrar lista de recetas favoritas
    public function index()
    {

        $usuario = Auth::user();
        $favoritas = $usuario->recetasFavoritas()->with('usuario')->get();
        $semanas = Semana::where('usuario_id', $usuario->id)->orderByDesc('inicio')->get();

        return view('recetas.favoritas', compact('favoritas', 'semanas'));
    }
}
