<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

/**
 * Gestiona la autenticación de usuarios (monitores y socios).
 * La autenticación es manual mediante sesiones, sin paquetes externos.
 */
class LoginController extends Controller
{
    /**
     * Muestra el formulario de inicio de sesión.
     */
    public function showLoginForm() {
        return view('login');
    }

    /**
     * Procesa las credenciales del formulario.
     * Busca el usuario en la tabla unificada 'usuarios' y comprueba la contraseña.
     * Si coinciden, guarda el id, nombre y rol en sesión y redirige al panel correspondiente.
     */
    public function authenticate(Request $request) {
        $usuario  = $request->input('usuario');
        $password = $request->input('password');

        $user = Usuario::where('usuario', $usuario)->first();

        if ($user && $user->password === $password) {
            $request->session()->put('user_id',   $user->id);
            $request->session()->put('user_name', $user->nombre);
            $request->session()->put('user_role', $user->rol);

            if ($user->rol === 'monitor') {
                return redirect()->route('monitor.panel');
            }
            return redirect()->route('socio.clases');
        }

        return back()->with('error', 'Usuario o contraseña incorrectos')->withInput();
    }

    /**
     * Cierra la sesión del usuario y redirige al login.
     */
    public function logout(Request $request) {
        $request->session()->invalidate();
        return redirect('/login');
    }
}
