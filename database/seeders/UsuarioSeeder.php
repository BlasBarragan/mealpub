<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    //Creamos usuario admin por defecto
    public function run(): void
    {
        Usuario::firstOrCreate([
            'nombre' => 'admin',
            'email' => 'admin@mealmate.com',
            'password' => Hash::make('230988'),
        ]);
    }
}
