<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Devolucion;
use App\Models\DetalleFactura;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;

class DevolucionController extends Controller
{
    public function index(Request $request)
    {
        $query = Devolucion::with(['detalleFactura.factura', 'detalleFactura.articulo']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('motivo', 'like', "%{$search}%")
                  ->orWhereHas('detalleFactura.factura', function($q) use ($search) {
                      $q->where('nro_factura', 'like', "%{$search}%");
                  })
                  ->orWhereHas('detalleFactura.articulo', function($q) use ($search) {
                      $q->where('descripcion', 'like', "%{$search}%");
                  });
            });
        }

        $devoluciones = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        return view('devoluciones.index', compact('devoluciones'));
    }

    public function create()
    {
        $facturas = Factura::with('cliente')->orderBy('created_at', 'desc')->get();
        return view('devoluciones.create', compact('facturas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cod_detallefactura' => 'required|exists:detalle_factura,id',
            'motivo' => 'required|string|max:40',
            'cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $detalle = DetalleFactura::with('articulo')->findOrFail($validated['cod_detallefactura']);

            // Check if return quantity is valid
            $totalDevuelto = Devolucion::where('cod_detallefactura', $detalle->id)->sum('cantidad');
            $cantidadDisponible = $detalle->cantidad - $totalDevuelto;

            if ($validated['cantidad'] > $cantidadDisponible) {
                throw new \Exception("La cantidad a devolver excede la cantidad disponible ({$cantidadDisponible})");
            }

            // Create return
            Devolucion::create([
                'cod_detallefactura' => $validated['cod_detallefactura'],
                'motivo' => $validated['motivo'],
                'fecha_devolucion' => date('Y-m-d'),
                'cantidad' => $validated['cantidad'],
            ]);

            // Restore stock
            $detalle->articulo->increaseStock($validated['cantidad']);

            DB::commit();

            return redirect()->route('devoluciones.index')->with('success', 'Devolución registrada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al registrar la devolución: ' . $e->getMessage());
        }
    }

    public function getDetalles($facturaId)
    {
        $detalles = DetalleFactura::with('articulo')
            ->where('cod_factura', $facturaId)
            ->get()
            ->map(function($detalle) {
                $totalDevuelto = Devolucion::where('cod_detallefactura', $detalle->id)->sum('cantidad');
                $detalle->cantidad_disponible = $detalle->cantidad - $totalDevuelto;
                return $detalle;
            });

        return response()->json($detalles);
    }
}
