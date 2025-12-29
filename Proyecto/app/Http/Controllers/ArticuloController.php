<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\TipoArticulo;
use App\Models\Proveedor;

class ArticuloController extends Controller
{
    public function index(Request $request)
    {
        $query = Articulo::with(['tipoArticulo', 'proveedor']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('descripcion', 'like', "%{$search}%")
                  ->orWhereHas('tipoArticulo', function($q) use ($search) {
                      $q->where('descripcion_articulo', 'like', "%{$search}%");
                  })
                  ->orWhereHas('proveedor', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('apellido', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting functionality
        $sortBy = $request->get('sort_by', 'id');
        $sortOrder = $request->get('sort_order', 'desc');

        // Always put inactive items at the bottom
        $query->orderByRaw("CASE WHEN estado = 'inactivo' THEN 1 ELSE 0 END ASC");

        switch ($sortBy) {
            case 'stock':
                $query->orderBy('stock', $sortOrder);
                break;
            case 'precio':
                $query->orderBy('precio_venta', $sortOrder);
                break;
            case 'ventas':
                // Order by most sold items (count of detalle_factura)
                $query->withCount('detallesFactura')
                      ->orderBy('detalles_factura_count', $sortOrder);
                break;
            default:
                $query->orderBy('id', $sortOrder);
        }

        $articulos = $query->paginate(10)->withQueryString();
        return view('articulos.index', compact('articulos'));
    }

    public function create()
    {
        $tiposArticulo = TipoArticulo::all();
        $proveedores = Proveedor::all();
        return view('articulos.create', compact('tiposArticulo', 'proveedores'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:40',
            'precio_venta' => 'required|integer|min:0',
            'precio_costo' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'cod_proveedor' => 'required|exists:proveedor,id',
            'cod_tipo_articulo' => 'required|exists:tipo_articulo,id',
        ]);

        Articulo::create($validated);

        return redirect()->route('articulos.index')->with('success', 'Artículo creado exitosamente.');
    }

    public function edit(Articulo $articulo)
    {
        $tiposArticulo = TipoArticulo::all();
        $proveedores = Proveedor::all();
        return view('articulos.edit', compact('articulo', 'tiposArticulo', 'proveedores'));
    }

    public function update(Request $request, Articulo $articulo)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string|max:40',
            'precio_venta' => 'required|integer|min:0',
            'precio_costo' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'cod_proveedor' => 'required|exists:proveedor,id',
            'cod_tipo_articulo' => 'required|exists:tipo_articulo,id',
        ]);

        $articulo->update($validated);

        return redirect()->route('articulos.index')->with('success', 'Artículo actualizado exitosamente.');
    }

    public function destroy(Articulo $articulo)
    {
        $articulo->desactivar();
        return redirect()->route('articulos.index')->with('success', 'Artículo desactivado exitosamente.');
    }

    public function activate(Articulo $articulo)
    {
        $articulo->activar();
        return redirect()->route('articulos.index')->with('success', 'Artículo activado exitosamente.');
    }

    public function updateStock(Request $request, Articulo $articulo)
    {
        $validated = $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $articulo->update(['stock' => $validated['stock']]);

        return redirect()->route('articulos.index')->with('success', 'Stock actualizado exitosamente.');
    }
}
