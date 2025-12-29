<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoArticulo;

class TipoArticuloController extends Controller
{
    public function index(Request $request)
    {
        $query = TipoArticulo::query();

        if ($request->filled('search')) {
            $query->where('descripcion_articulo', 'like', "%{$request->search}%");
        }

        if ($request->filled('estado')) {
            if ($request->estado === 'activo') {
                $query->activos();
            } elseif ($request->estado === 'inactivo') {
                $query->inactivos();
            }
        } else {
            $query->activos();
        }

        $tiposArticulo = $query->orderBy('descripcion_articulo')->paginate(15)->withQueryString();
        
        return view('tipos-articulo.index', compact('tiposArticulo'));
    }

    public function create()
    {
        return view('tipos-articulo.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion_articulo' => 'required|string|max:50|unique:tipo_articulo,descripcion_articulo',
        ]);

        $validated['estado'] = 'activo';

        TipoArticulo::create($validated);

        return redirect()->route('tipos-articulo.index')->with('success', 'Tipo de artículo creado exitosamente.');
    }

    public function edit(TipoArticulo $tiposArticulo)
    {
        return view('tipos-articulo.edit', compact('tiposArticulo'));
    }

    public function update(Request $request, TipoArticulo $tiposArticulo)
    {
        $validated = $request->validate([
            'descripcion_articulo' => 'required|string|max:50|unique:tipo_articulo,descripcion_articulo,' . $tiposArticulo->id,
        ]);

        $tiposArticulo->update($validated);

        return redirect()->route('tipos-articulo.index')->with('success', 'Tipo de artículo actualizado exitosamente.');
    }

    public function destroy(TipoArticulo $tiposArticulo)
    {
        if ($tiposArticulo->articulos()->count() > 0) {
            return back()->with('error', 'No se puede desactivar el tipo de artículo porque tiene artículos asociados.');
        }

        $tiposArticulo->desactivar();

        return redirect()->route('tipos-articulo.index')->with('success', 'Tipo de artículo desactivado exitosamente.');
    }

    public function activate(TipoArticulo $tiposArticulo)
    {
        $tiposArticulo->activar();

        return redirect()->route('tipos-articulo.index')->with('success', 'Tipo de artículo activado exitosamente.');
    }
}
