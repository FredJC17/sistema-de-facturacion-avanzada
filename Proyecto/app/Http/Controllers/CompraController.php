<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Articulo;
use Illuminate\Support\Facades\Storage;

class CompraController extends Controller
{
    public function index(Request $request)
    {
        $query = Compra::with(['articulo.tipoArticulo']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('articulo', function($q) use ($search) {
                $q->where('descripcion', 'like', "%{$search}%");
            });
        }

        // Sorting - handle combined dropdown value
        $sortParam = $request->get('sort', 'fecha_compra_desc');
        
        // Parse the sort parameter
        if (strpos($sortParam, '_desc') !== false) {
            $sortField = str_replace('_desc', '', $sortParam);
            $sortDirection = 'desc';
        } elseif (strpos($sortParam, '_asc') !== false) {
            $sortField = str_replace('_asc', '', $sortParam);
            $sortDirection = 'asc';
        } else {
            $sortField = 'fecha_compra';
            $sortDirection = 'desc';
        }
        
        // Override direction if direction_sort is provided
        if ($request->filled('direction_sort')) {
            $sortDirection = $request->get('direction_sort');
        }
        
        $query->orderBy($sortField, $sortDirection);

        $compras = $query->paginate(15);

        return view('compras.index', compact('compras', 'sortField', 'sortDirection'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cod_articulo' => 'required|exists:articulo,id',
            'cantidad' => 'required|integer|min:1',
            'fecha_compra' => 'required|date',
            'precio_compra' => 'required|numeric|min:0',
            'precio_venta' => 'nullable|numeric|min:0',
            'comprobante' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        // File Upload
        $path = null;
        if ($request->hasFile('comprobante')) {
            $path = $request->file('comprobante')->store('comprobantes', 'public');
        }

        // Create Purchase Record
        $compra = Compra::create([
            'cod_articulo' => $validated['cod_articulo'],
            'cantidad' => $validated['cantidad'],
            'fecha_compra' => $validated['fecha_compra'],
            'precio_compra' => $validated['precio_compra'],
            'precio_venta' => $validated['precio_venta'] ?? 0,
            'comprobante_path' => $path,
        ]);

        // Update Article Stock and Prices
        $articulo = Articulo::findOrFail($validated['cod_articulo']);
        $articulo->stock += $validated['cantidad'];
        $articulo->precio_costo = $validated['precio_compra'];
        
        if (!empty($validated['precio_venta'])) {
            $articulo->precio_venta = $validated['precio_venta'];
        }
        
        $articulo->save();

        return redirect()->route('articulos.index')->with('success', 'Stock reabastecido y precios actualizados exitosamente.');
    }

    public function downloadReceipt(Compra $compra)
    {
        if (!$compra->comprobante_path || !Storage::disk('public')->exists($compra->comprobante_path)) {
            return redirect()->back()->with('error', 'No hay comprobante disponible para descargar.');
        }

        return Storage::disk('public')->download($compra->comprobante_path);
    }

    public function printReceipt(Compra $compra)
    {
        if (!$compra->comprobante_path || !Storage::disk('public')->exists($compra->comprobante_path)) {
            return redirect()->back()->with('error', 'No hay comprobante disponible para imprimir.');
        }

        $filePath = Storage::disk('public')->path($compra->comprobante_path);
        $fileType = Storage::disk('public')->mimeType($compra->comprobante_path);

        // Return file for inline display (print preview)
        return response()->file($filePath, [
            'Content-Type' => $fileType,
            'Content-Disposition' => 'inline; filename="' . basename($compra->comprobante_path) . '"'
        ]);
    }
}
