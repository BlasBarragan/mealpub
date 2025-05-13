<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // Solo usuarios sin login pueden acceder al formulario de registro, asi evitamos que un usuario ya registrado, vuelva a registrarse
    public function __construct()
    {
        $this->middleware('guest');
    }

    // Mostrar la vista del formulario de registro
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // REGISTRO DE USUARIO
    public function register(Request $request)
    {
        // Validar datos del formulario
        $data = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:usuarios,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // Crear el nuevo usuario en la base de datos
        $usuario = Usuario::create([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Iniciar sesion automaticamente al registrarse
        Auth::login($usuario);
        return redirect()->route('panel');
    }
}
