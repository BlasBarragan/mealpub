<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetaSemana extends Model
{
    use HasFactory;

    // Definimos la tabla asociada al modelo
    protected $table = 'recetas_semanas';
    // Definimos los campos asignables
    protected $fillable = [
        'semana_id',
        'dia_semana',
        'desayuno_receta_id',
        'comida_receta_id',
        'merienda_receta_id',
        'cena_receta_id',
    ];

    // RELACIONES
    // Relacion uno a muchos RecetaSemana<->Semana (tabla recetas_semanas)
    public function semana()
    {
        return $this->belongsTo(Semana::class);
    }
    // Relacion uno a muchos RecetaSemana<->Receta (tabla recetas_semanas) de cada momento (desayuno, comida, merienda y cena)
    public function desayuno()
    {
        return $this->belongsTo(Receta::class, 'desayuno_receta_id');
    }
    public function comida()
    {
        return $this->belongsTo(Receta::class, 'comida_receta_id');
    }
    public function merienda()
    {
        return $this->belongsTo(Receta::class, 'merienda_receta_id');
    }
    public function cena()
    {
        return $this->belongsTo(Receta::class, 'cena_receta_id');
    }
}
