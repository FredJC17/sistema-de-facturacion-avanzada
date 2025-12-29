<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\TipoDocumento;
use App\Models\Ciudad;

class ProveedorController extends Controller
{
    public function index(Request $request)
    {
        $query = Proveedor::with(['tipoDocumento', 'ciudad']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('apellido', 'like', "%{$search}%")
                  ->orWhere('nro_documento', 'like', "%{$search}%")
                  ->orWhereHas('ciudad', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting functionality
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        // Always put inactive items at the bottom
        $query->orderByRaw("CASE WHEN estado = 'inactivo' THEN 1 ELSE 0 END ASC");

        switch ($sortBy) {
            case 'articulos':
                // Order by number of articles supplied
                $query->withCount('articulos')
                      ->orderBy('articulos_count', $sortOrder);
                break;
            case 'nombre':
                $query->orderBy('nombre', $sortOrder);
                break;
            default:
                $query->orderBy('id', $sortOrder);
        }

        $proveedores = $query->paginate(10)->withQueryString();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        $tiposDocumento = TipoDocumento::all();
        $ciudades = Ciudad::all();
        return view('proveedores.create', compact('tiposDocumento', 'ciudades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nro_documento' => 'required|string|max:20',
            'cod_tipo_documento' => 'required|exists:tipo_documento,id',
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'cod_ciudad' => 'required|exists:ciudad,id',
            'direccion' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:15',
        ]);

        Proveedor::create($validated);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado exitosamente.');
    }

    public function edit(Proveedor $proveedor)
    {
        $tiposDocumento = TipoDocumento::all();
        $ciudades = Ciudad::all();
        return view('proveedores.edit', compact('proveedor', 'tiposDocumento', 'ciudades'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'nro_documento' => 'required|string|max:20',
            'cod_tipo_documento' => 'required|exists:tipo_documento,id',
            'nombre' => 'required|string|max:30',
            'apellido' => 'required|string|max:30',
            'cod_ciudad' => 'required|exists:ciudad,id',
            'direccion' => 'nullable|string|max:20',
            'telefono' => 'nullable|string|max:15',
        ]);

        $proveedor->update($validated);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado exitosamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->desactivar();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor desactivado exitosamente.');
    }

    public function activate(Proveedor $proveedor)
    {
        $proveedor->activar();
        return redirect()->route('proveedores.index')->with('success', 'Proveedor activado exitosamente.');
    }
}
