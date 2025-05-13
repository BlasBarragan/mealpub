<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PerfilController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nombre' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
        ]);

        // Si el usuario quiere cambiar la contraseña, validamos y pedimos la actual
        if ($request->filled('password')) {
            // Validamos que se ingrese la contraseña actual
            if (!$request->filled('password_actual')) {
                return back()->withErrors(['password_actual' => 'Debes introducir tu contraseña actual para cambiar la contraseña.'])->withInput();
            }
            // Validamos la contraseña actual ingresada
            if (!Hash::check($request->input('password_actual'), $user->password)) {
                return back()->withErrors(['password_actual' => 'La contraseña actual no es correcta.'])->withInput();
            }
            // Validamos que la nueva contraseña y la confirmación sean iguales
            if ($request->password !== $request->password_confirmation) {
                return back()->withErrors(['password' => 'Las contraseñas no coinciden.'])->withInput();
            }

            $user->password = Hash::make($request->password);
        }

        $user->nombre = $request->nombre;
        $user->save();

        return redirect()->route('perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
