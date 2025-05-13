<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    // Definimos la tabla asociada al modelo
    protected $table = 'usuarios';
    // Definimos los campos asignables
    protected $fillable = [
        'nombre',
        'email',
        'password',
    ];
    // Definimos los campos que no uqeremos que se muestren
    protected $hidden = ['password'];

    // RELACIONES
    // Relacion uno a muchos Usuario<->Semana (tabla recetas_semana)
    public function semanas()
    {
        return $this->hasMany(Semana::class);
    }
    // Relacion uno a muchos Usuario<->Receta (tabla recetas)
    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }
    // Relacion muchos a muchos Usuario<->Receta (tabla recetas_favoritas)
    public function recetasFavoritas()
    {
        return $this->belongsToMany(Receta::class, 'recetas_favoritas', 'usuario_id', 'receta_id');
    }
}
