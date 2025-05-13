<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetasIngrediente extends Model
{
    use HasFactory;

    // Definimos la tabla asociada al modelo
    protected $table = 'recetas_ingredientes';
    // Definimos los campos asignables
    protected $fillable = [
        'recetas_id',
        'ingredientes_id',
        'cantidad',
        'unidad',
    ];

    // RELACIONES
    // Relacion uno a muchos RecetasIngrediente<->Receta (tabla recetas_ingredientes)
    public function receta()
    {
        return $this->belongsTo(Receta::class, 'recetas_id');
    }
    // Relacion uno a muchos RecetasIngrediente<->Ingrediente (tabla recetas_ingredientes)
    public function ingrediente()
    {
        return $this->belongsTo(Ingrediente::class, 'ingredientes_id');
    }
}
