<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDocumento;

class TipoDocumentoController extends Controller
{
    public function index(Request $request)
    {
        $query = TipoDocumento::query();

        if ($request->filled('search')) {
            $query->where('descripcion', 'like', "%{$request->search}%");
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

        $tiposDocumento = $query->orderBy('descripcion')->paginate(15)->withQueryString();
        
        return view('tipos-documento.index', compact('tiposDocumento'));
    }

    public function create()
    {
        return view('tipos-documento.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:50|unique:tipo_documento,descripcion',
        ]);

        $validated['estado'] = 'activo';

        TipoDocumento::create($validated);

        return redirect()->route('tipos-documento.index')->with('success', 'Tipo de documento creado exitosamente.');
    }

    public function edit(TipoDocumento $tiposDocumento)
    {
        return view('tipos-documento.edit', compact('tiposDocumento'));
    }

    public function update(Request $request, TipoDocumento $tiposDocumento)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:50|unique:tipo_documento,descripcion,' . $tiposDocumento->id,
        ]);

        $tiposDocumento->update($validated);

        return redirect()->route('tipos-documento.index')->with('success', 'Tipo de documento actualizado exitosamente.');
    }

    public function destroy(TipoDocumento $tiposDocumento)
    {
        if ($tiposDocumento->clientes()->count() > 0 || $tiposDocumento->proveedores()->count() > 0) {
            return back()->with('error', 'No se puede desactivar el tipo de documento porque tiene clientes o proveedores asociados.');
        }

        $tiposDocumento->desactivar();

        return redirect()->route('tipos-documento.index')->with('success', 'Tipo de documento desactivado exitosamente.');
    }

    public function activate(TipoDocumento $tiposDocumento)
    {
        $tiposDocumento->activar();

        return redirect()->route('tipos-documento.index')->with('success', 'Tipo de documento activado exitosamente.');
    }
}
