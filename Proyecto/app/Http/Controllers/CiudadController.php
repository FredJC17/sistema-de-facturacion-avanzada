<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ciudad;

class CiudadController extends Controller
{
    public function index(Request $request)
    {
        $query = Ciudad::query();

        // Filtro de búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo_ciudad', 'like', "%{$search}%")
                  ->orWhere('nombre', 'like', "%{$search}%");
            });
        }

        // Filtro de estado
        if ($request->filled('estado')) {
            if ($request->estado === 'activo') {
                $query->activos();
            } elseif ($request->estado === 'inactivo') {
                $query->inactivos();
            }
        } else {
            // Por defecto, mostrar solo activos
            $query->activos();
        }

        $ciudades = $query->orderBy('nombre')->paginate(15)->withQueryString();
        
        return view('ciudades.index', compact('ciudades'));
    }

    public function create()
    {
        return view('ciudades.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'codigo_ciudad' => 'required|string|max:10|unique:ciudad,codigo_ciudad',
            'nombre' => 'required|string|max:100',
        ]);

        $validated['estado'] = 'activo';

        Ciudad::create($validated);

        return redirect()->route('ciudades.index')->with('success', 'Ciudad creada exitosamente.');
    }

    public function edit(Ciudad $ciudad)
    {
        return view('ciudades.edit', compact('ciudad'));
    }

    public function update(Request $request, Ciudad $ciudad)
    {
        $validated = $request->validate([
            'codigo_ciudad' => 'required|string|max:10|unique:ciudad,codigo_ciudad,' . $ciudad->id,
            'nombre' => 'required|string|max:100',
        ]);

        $ciudad->update($validated);

        return redirect()->route('ciudades.index')->with('success', 'Ciudad actualizada exitosamente.');
    }

    public function destroy(Ciudad $ciudad)
    {
        // Verificar si tiene relaciones
        if ($ciudad->clientes()->count() > 0 || $ciudad->proveedores()->count() > 0) {
            return back()->with('error', 'No se puede desactivar la ciudad porque tiene clientes o proveedores asociados.');
        }

        $ciudad->desactivar();

        return redirect()->route('ciudades.index')->with('success', 'Ciudad desactivada exitosamente.');
    }

    public function activate(Ciudad $ciudad)
    {
        $ciudad->activar();

        return redirect()->route('ciudades.index')->with('success', 'Ciudad activada exitosamente.');
    }
}
