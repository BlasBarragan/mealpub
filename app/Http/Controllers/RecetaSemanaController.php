<?php

namespace App\Http\Controllers;

use App\Models\RecetaSemana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class RecetaSemanaController extends Controller
{
    // Guardamos una receta en una semana concreta de las que el usuario tiene creadas (dia + momento)
    public function store(Request $request)
    {   // validamos el formulario
        $data = $request->validate([
            'semana_id' => 'required|exists:semanas,id',
            'receta_id' => 'required|exists:recetas,id',
            'dia_semana' => 'required|in:lunes,martes,miércoles,jueves,viernes,sábado,domingo',
            'momento' => 'required|in:desayuno,comida,merienda,cena',
        ]);

        // Buscar el ID de la relacion entre la semana y el dia de la semana seleccionados
        $registro = RecetaSemana::where('semana_id', $data['semana_id'])
            ->where('dia_semana', $data['dia_semana'])
            ->firstOrFail();


        // Añadimos la receta al momento correspondiente de la semana
        $registro->{$data['momento'] . '_receta_id'} = $data['receta_id'];
        $registro->save();

        return Redirect::back()->with('success', 'Receta añadida correctamente.');
    }
}
