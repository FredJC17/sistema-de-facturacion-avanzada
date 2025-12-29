<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\DetalleFactura;
use App\Models\Cliente;
use App\Models\Articulo;
use Illuminate\Support\Facades\DB;

class FacturaController extends Controller
{
    public function index(Request $request)
    {
        $query = Factura::with('cliente');

        // Search functionality
        if ($request->filled('search')) {
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

        $facturas = $query->orderBy('id', 'desc')->get();
        return view('facturas.index', compact('facturas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $articulos = Articulo::where('stock', '>', 0)->get();
        return view('facturas.create', compact('clientes', 'articulos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cod_cliente' => 'required|exists:cliente,id',
            'articulos' => 'required|array|min:1',
            'articulos.*.id' => 'required|exists:articulo,id',
            'articulos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Calcular subtotal primero
            $subtotal = 0;
            $articulosParaValidar = [];
            
            foreach ($validated['articulos'] as $item) {
                $articulo = Articulo::findOrFail($item['id']);
                
                // Verificar stock
                if (!$articulo->hasStock($item['cantidad'])) {
                    throw new \Exception("Stock insuficiente para el artículo: {$articulo->descripcion}");
                }
                
                $lineTotal = $articulo->precio_venta * $item['cantidad'];
                $subtotal += $lineTotal;
                
                $articulosParaValidar[] = [
                    'articulo' => $articulo,
                    'cantidad' => $item['cantidad'],
                    'total' => $lineTotal
                ];
            }

            // Calcular IGV (18%) y Total
            $igv = $subtotal * 0.18;
            $total = $subtotal + $igv;

            // Crear factura con todos los valores
            $factura = Factura::create([
                'nro_factura' => Factura::generateInvoiceNumber(),
                'cod_cliente' => $validated['cod_cliente'],
                'fecha_emision' => date('Y-m-d'),
                'fecha_facturacion' => date('Y-m-d'),
                'subtotal' => $subtotal,
                'igv' => $igv,
                'total_factura' => $total,
                'estado' => 'activo',
            ]);

            // Crear detalles y actualizar stock
            foreach ($articulosParaValidar as $item) {
                DetalleFactura::create([
                    'cod_factura' => $factura->id,
                    'cod_articulo' => $item['articulo']->id,
                    'cantidad' => $item['cantidad'],
                    'total' => $item['total'],
                ]);

                // Reducir stock
                $item['articulo']->reduceStock($item['cantidad']);
            }

            DB::commit();

            return redirect()->route('facturas.show', $factura)->with('success', 'Factura creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Error al crear la factura: ' . $e->getMessage());
        }
    }

    public function show(Factura $factura)
    {
        $factura->load(['cliente', 'detalles.articulo']);
        return view('facturas.show', compact('factura'));
    }

    public function print(Factura $factura)
    {
        $factura->load(['cliente', 'detalles.articulo']);
        $isPdf = false;
        return view('facturas.print', compact('factura', 'isPdf'));
    }

    public function download(Factura $factura)
    {
        $factura->load(['cliente', 'detalles.articulo']);
        $isPdf = true;
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('facturas.print', compact('factura', 'isPdf'));
        return $pdf->download('factura-' . $factura->nro_factura . '.pdf');
    }
}
