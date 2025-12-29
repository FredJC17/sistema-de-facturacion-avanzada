<?php

namespace App\Http\Controllers;

use App\Models\Factura;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Factura::with(['cliente', 'detalles.articulo']);

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nro_factura', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('apellido', 'like', "%{$search}%")
                        ->orWhere('documento', 'like', "%{$search}%");
                  });
            });
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'fecha_emision');
        $sortOrder = $request->get('sort_order', 'desc');

        switch ($sortBy) {
            case 'monto':
                $query->orderBy('total_factura', $sortOrder);
                break;
            case 'cliente':
                // Join to sort by client name if needed, or simple sort by ID
                // For simplicity/performance, we might stick to simple sorts or use a join
                 $query->leftJoin('clientes', 'facturas.cod_cliente', '=', 'clientes.id')
                       ->orderBy('clientes.nombre', $sortOrder)
                       ->select('facturas.*'); // Avoid column collision
                break;
            case 'fecha_emision':
            default:
                $query->orderBy('fecha_emision', $sortOrder);
                break;
        }

        $ventas = $query->get();

        return view('ventas.index', compact('ventas'));
    }
}
