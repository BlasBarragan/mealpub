<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetaFavorita extends Model
{
    use HasFactory;

    // Definimos la tabla asociada al modelo
    protected $table = 'recetas_favoritas';
    // Definimos los campos asignables
    protected $fillable = [
        'usuario_id',
        'receta_id',
    ];

    // RELACIONES
    // Relacion uno a muchos RecetaFavorita<->Usuario (tabla recetas_favoritas)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
    // Relacion uno a muchos RecetaFavorita<->Receta (tabla recetas_favoritas)
    public function receta()
    {
        return $this->belongsTo(Receta::class);
    }
}
