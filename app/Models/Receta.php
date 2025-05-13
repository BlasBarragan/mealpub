<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    use HasFactory;

    // Definimos la tabla asociada al modelo
    protected $table = 'recetas';
    // Definimos los campos asignables
    protected $fillable = [
        'usuario_id',
        'nombre',
        'raciones',
        'n_votos',
        'puntuacion',
        'tipo_receta',
        'dificultad',
    ];

    // RELACIONES
    // Relacion uno a uno Receta<->Usuario (tabla recetas)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    // public function recetasFavoritas()
    // {
    //     return $this->hasMany(RecetaFavorita::class);
    // }

    // Relacion muchos a muchos Receta<->Usuario (tabla recetas_favoritas)
    public function usuariosFavoritos()
    {
        return $this->belongsToMany(Usuario::class, 'recetas_favoritas', 'receta_id', 'usuario_id');
    }

    // Relacion uno a muchos Receta<->RecetaSemana (tabla recetas_semanas) de cada momento (desayuno, comida, merienda y cena)
    public function recetasSemanaComoDesayuno()
    {
        return $this->hasMany(RecetaSemana::class, 'desayuno_receta_id');
    }
    public function recetasSemanaComoComida()
    {
        return $this->hasMany(RecetaSemana::class, 'comida_receta_id');
    }
    public function recetasSemanaComoMerienda()
    {
        return $this->hasMany(RecetaSemana::class, 'merienda_receta_id');
    }
    public function recetasSemanaComoCena()
    {
        return $this->hasMany(RecetaSemana::class, 'cena_receta_id');
    }
    // Relacion uno a muchos Receta<->RecetaIngrediente (tabla recetas_ingredientes)
    public function ingredientes()
    {
        return $this->belongsToMany(Ingrediente::class, 'recetas_ingredientes', 'recetas_id', 'ingredientes_id')
            ->withPivot('cantidad', 'unidad');
    }
}
