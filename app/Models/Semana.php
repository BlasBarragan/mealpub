<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semana extends Model
{
    use HasFactory;

    // Definimos la tabla asociada al modelo
    protected $table = 'semanas';
    // Definimos los campos asignables
    protected $fillable = [
        'usuario_id',
        'inicio',
        'fin',
    ];

    // RELACIONES
    // Relacion uno a muchos Semana<->Usuario (tabla semanas)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }
    // Relacion uno a muchos Semana<->RecetaSemana (tabla recetas_semanas)
    public function recetasSemana()
    {
        return $this->hasMany(RecetaSemana::class);
    }
}
