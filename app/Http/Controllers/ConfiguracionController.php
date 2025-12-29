<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Configuracion;
use Illuminate\Support\Facades\Auth;

class ConfiguracionController extends Controller
{
    /**
     * Cambiar tema del usuario
     */
    public function cambiarTema(Request $request)
    {
        $request->validate([
            'tema' => 'required|in:claro,oscuro',
        ]);

        $usuario = Auth::user();
        
        // Obtener o crear configuración
        $configuracion = Configuracion::obtenerOCrear($usuario->id);
        
        // Cambiar tema
        $configuracion->cambiarTema($request->tema);

        return response()->json([
            'success' => true,
            'tema' => $request->tema,
            'message' => 'Tema actualizado correctamente'
        ]);
    }

    /**
     * Obtener configuración actual del usuario
     */
    public function obtener()
    {
        $usuario = Auth::user();
        $configuracion = Configuracion::obtenerOCrear($usuario->id);

        return response()->json([
            'tema' => $configuracion->tema,
            'idioma' => $configuracion->idioma
        ]);
    }

    /**
     * Guardar configuración completa
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'tema' => 'sometimes|in:claro,oscuro',
            'idioma' => 'sometimes|string|max:5',
        ]);

        $usuario = Auth::user();
        $configuracion = Configuracion::obtenerOCrear($usuario->id);

        if ($request->has('tema')) {
            $configuracion->tema = $request->tema;
        }

        if ($request->has('idioma')) {
            $configuracion->idioma = $request->idioma;
        }

        $configuracion->save();

        return response()->json([
            'success' => true,
            'message' => 'Configuración guardada correctamente'
        ]);
    }
}
