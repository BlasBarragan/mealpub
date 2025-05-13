<?php

namespace Database\Seeders;

use App\Models\Ingrediente;
use Illuminate\Database\Seeder;

class IngredienteSeeder extends Seeder
{
    //Creamos un ingrediente por cada tipo de ingrediente para llenar un poco la tabla
    public function run(): void
    {
        $tipos = ['fruta', 'verdura', 'carne', 'pescado', 'ave', 'especia', 'lacteo', 'cereal', 'legumbre'];
        foreach ($tipos as $tipo) {
            Ingrediente::create([
                'nombre' => ucfirst($tipo),
                'tipo' => $tipo,
            ]);
        }
    }
}
