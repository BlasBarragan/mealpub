<?php

namespace App\Http\Controllers;

use App\Models\Ingrediente;


class IngredienteController extends Controller
{
    // Elimina ingredientes de la base de datos cuando eliminamos una receta
    public function destroy(Ingrediente $ingrediente)
    {
        // Si hay recetas que usan este ingrediente, no se puede eliminar
        if ($ingrediente->recetas()->exists()) {
            return redirect()->back()->with('error', 'No puedes eliminar este ingrediente porque está en uso.');
        }

        $ingrediente->delete();
        return redirect()->route('ingredientes.index')->with('success', 'Ingrediente eliminado.');
    }
}
