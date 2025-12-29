<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;
use App\Models\TipoDocumento;
use App\Models\Ciudad;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $loginField = $request->input('login');
        $password = $request->input('password');

        // Intentar encontrar el usuario por email, nombre o documento
        $cliente = Cliente::where('email', $loginField)
            ->orWhere('nombre', $loginField)
            ->orWhere('documento', $loginField)
            ->first();

        // Verificar si el usuario existe y la contraseña es correcta
        if ($cliente && Hash::check($password, $cliente->password)) {
            Auth::login($cliente, $request->filled('remember'));
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'login' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('login');
    }

    public function showRegister()
    {
        $tiposDocumento = TipoDocumento::all();
        $ciudades = Ciudad::all();
        return view('auth.register', compact('tiposDocumento', 'ciudades'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'documento' => 'required|string|max:15|unique:cliente,documento',
            'cod_tipo_documento' => 'required|exists:tipo_documento,id',
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'direccion' => 'nullable|string|max:20',
            'cod_ciudad' => 'required|exists:ciudad,id',
            'telefono' => 'nullable|string|max:15',
            'email' => 'required|email|unique:cliente,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['rol'] = 'client'; // Default role

        $cliente = Cliente::create($validated);

        Auth::login($cliente);

        return redirect()->route('dashboard')->with('success', '¡Registro exitoso! Bienvenido.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Sesión cerrada correctamente.');
    }
}
