<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Mostrar el formulario para el inicio de sesion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // INICIO DE SESION
    public function login(Request $request)
    {
        // Validar los datos del formulario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);
        // Intentar autenticar al usuario
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('panel');
        }
        // Si falla el login se vuelve atras con mensajwe de error y el email ya escrito
        return back()->withErrors([
            'email' => 'Email de usuario o contraseña incorrectos.',
        ])->onlyInput('email');
    }

    // CERRAR SESION
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('inicio');
    }
}
