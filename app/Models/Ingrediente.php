<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    use HasFactory;

    // Definimos la tabla asociada al modelo
    protected $table = 'ingredientes';
    // Definimos los campos asignables
    protected $fillable = [
        'nombre',
        'tipo',
    ];

    // RELACIONES
    // Relacion muchos a muchos Ingrediente<->Receta (tabla recetas_ingredientes)
    public function recetas()
    {
        return $this->belongsToMany(Receta::class, 'recetas_ingredientes', 'ingredientes_id', 'recetas_id')
            ->withPivot('cantidad', 'unidad');
    }
}
