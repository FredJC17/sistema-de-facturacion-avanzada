<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Articulo;
use App\Models\Cliente;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class ReporteCentralController extends Controller
{
    public function index()
    {
        // 1. Estadísticas de Ventas (Últimos 6 meses)
        $dbDriver = DB::connection()->getDriverName();
        $dateFormat = $dbDriver === 'sqlite' ? 'strftime("%Y-%m", fecha_emision)' : 'DATE_FORMAT(fecha_emision, "%Y-%m")';

        $ventasMes = DB::table('factura')
            ->select(DB::raw("$dateFormat as mes"), DB::raw('sum(total_factura) as total'))
            ->where('estado', '!=', 'anulado')
            ->where('fecha_emision', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $chartVentas = [
            'labels' => $ventasMes->pluck('mes')->toArray(),
            'data' => $ventasMes->pluck('total')->toArray()
        ];

        // 2. Artículos más vendidos (Top 5)
        $topArticulos = DB::table('detalle_factura')
            ->join('articulo', 'detalle_factura.cod_articulo', '=', 'articulo.id')
            ->select('articulo.descripcion', DB::raw('sum(detalle_factura.cantidad) as total_vendido'))
            ->groupBy('articulo.id', 'articulo.descripcion')
            ->orderByDesc('total_vendido')
            ->limit(5)
            ->get();

        $chartArticulos = [
            'labels' => $topArticulos->pluck('descripcion')->toArray(),
            'data' => $topArticulos->pluck('total_vendido')->toArray()
        ];

        // 3. Mejores Clientes (Top 5 por monto)
        $topClientes = DB::table('factura')
            ->join('cliente', 'factura.cod_cliente', '=', 'cliente.id')
            ->select('cliente.nombre', 'cliente.apellido', DB::raw('sum(factura.total_factura) as total_comprado'))
            ->groupBy('cliente.id', 'cliente.nombre', 'cliente.apellido')
            ->orderByDesc('total_comprado')
            ->limit(5)
            ->get();

        $chartClientes = [
            'labels' => $topClientes->map(fn($c) => $c->nombre . ' ' . $c->apellido)->toArray(),
            'data' => $topClientes->pluck('total_comprado')->toArray()
        ];

        // 4. Proveedores con mayor gasto en compras (Top 5)
        $topProveedores = DB::table('compra')
            ->join('articulo', 'compra.cod_articulo', '=', 'articulo.id')
            ->join('proveedor', 'articulo.cod_proveedor', '=', 'proveedor.id')
            ->select('proveedor.nombre', DB::raw('sum(compra.precio_compra * compra.cantidad) as gasto_total'))
            ->groupBy('proveedor.id', 'proveedor.nombre')
            ->orderByDesc('gasto_total')
            ->limit(5)
            ->get();

        $chartProveedores = [
            'labels' => $topProveedores->pluck('nombre')->toArray(),
            'data' => $topProveedores->pluck('gasto_total')->toArray()
        ];

        // 5. Rentabilidad: Ingresos vs Gastos (Últimos 6 meses)
        // Ingresos por mes
        $ingresosMes = DB::table('factura')
            ->select(DB::raw("$dateFormat as mes"), DB::raw('sum(total_factura) as ingresos'))
            ->where('estado', '!=', 'anulado')
            ->where('fecha_emision', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Gastos por mes (de compras)
        $dateFormatCompra = $dbDriver === 'sqlite' ? 'strftime("%Y-%m", fecha_compra)' : 'DATE_FORMAT(fecha_compra, "%Y-%m")';
        
        $gastosMes = DB::table('compra')
            ->select(DB::raw("$dateFormatCompra as mes"), DB::raw('sum(precio_compra * cantidad) as gastos'))
            ->where('fecha_compra', '>=', now()->subMonths(6))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Combinar ingresos y gastos
        $meses = $ingresosMes->pluck('mes')->merge($gastosMes->pluck('mes'))->unique()->sort()->values();
        $ingresosArray = [];
        $gastosArray = [];

        foreach ($meses as $mes) {
            $ingreso = $ingresosMes->firstWhere('mes', $mes);
            $gasto = $gastosMes->firstWhere('mes', $mes);
            
            $ingresosArray[] = $ingreso ? (float)$ingreso->ingresos : 0;
            $gastosArray[] = $gasto ? (float)$gasto->gastos : 0;
        }

        $chartRentabilidad = [
            'labels' => $meses->toArray(),
            'ingresos' => $ingresosArray,
            'gastos' => $gastosArray
        ];

        return view('reportes.index', compact('chartVentas', 'chartArticulos', 'chartClientes', 'chartProveedores', 'chartRentabilidad'));
    }

    public function getRentabilidadData(Request $request)
    {
        try {
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFin = $request->input('fecha_fin');
            $articulosParam = $request->input('articulos'); // "1,2,3" or null
            
            $articulosIds = $articulosParam ? explode(',', $articulosParam) : [];

            // Determine grouping based on duration
            $start = \Carbon\Carbon::parse($fechaInicio);
            $end = \Carbon\Carbon::parse($fechaFin);
            $daysDiff = $start->diffInDays($end);
            
            $groupByDay = $daysDiff <= 60;

            $dbDriver = DB::connection()->getDriverName();
            
            if ($groupByDay) {
                $dateFormat = $dbDriver === 'sqlite' ? 'strftime("%Y-%m-%d", factura.fecha_emision)' : 'DATE_FORMAT(factura.fecha_emision, "%Y-%m-%d")';
                $dateFormatCompra = $dbDriver === 'sqlite' ? 'strftime("%Y-%m-%d", fecha_compra)' : 'DATE_FORMAT(fecha_compra, "%Y-%m-%d")';
            } else {
                $dateFormat = $dbDriver === 'sqlite' ? 'strftime("%Y-%m", factura.fecha_emision)' : 'DATE_FORMAT(factura.fecha_emision, "%Y-%m")';
                $dateFormatCompra = $dbDriver === 'sqlite' ? 'strftime("%Y-%m", fecha_compra)' : 'DATE_FORMAT(fecha_compra, "%Y-%m")';
            }

            // Ingresos por periodo
            $queryIngresos = DB::table('factura')
                ->where('factura.estado', '!=', 'anulado')
                ->whereBetween('factura.fecha_emision', [$fechaInicio, $fechaFin]);
            
            if (!empty($articulosIds)) {
                $ingresosData = $queryIngresos
                    ->join('detalle_factura', 'factura.id', '=', 'detalle_factura.cod_factura')
                    ->whereIn('detalle_factura.cod_articulo', $articulosIds)
                    ->select(DB::raw("$dateFormat as periodo"), DB::raw('sum(detalle_factura.total) as ingresos'))
                    ->groupBy('periodo')
                    ->orderBy('periodo')
                    ->get();
            } else {
                $ingresosData = $queryIngresos
                    ->select(DB::raw("$dateFormat as periodo"), DB::raw('sum(factura.total_factura) as ingresos'))
                    ->groupBy('periodo')
                    ->orderBy('periodo')
                    ->get();
            }

            // Gastos por periodo
            $gastosQuery = DB::table('compra')
                ->select(DB::raw("$dateFormatCompra as periodo"), DB::raw('sum(precio_compra * cantidad) as gastos'))
                ->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);
            
            if (!empty($articulosIds)) {
                $gastosQuery->whereIn('cod_articulo', $articulosIds);
            }
            
            $gastosData = $gastosQuery
                ->groupBy('periodo')
                ->orderBy('periodo')
                ->get();

            // Combinar ingresos y gastos
            $periodos = $ingresosData->pluck('periodo')->merge($gastosData->pluck('periodo'))->unique()->sort()->values();
            $ingresosArray = [];
            $gastosArray = [];

            foreach ($periodos as $periodo) {
                $ingreso = $ingresosData->firstWhere('periodo', $periodo);
                $gasto = $gastosData->firstWhere('periodo', $periodo);
                
                $ingresosArray[] = $ingreso ? (float)$ingreso->ingresos : 0;
                $gastosArray[] = $gasto ? (float)$gasto->gastos : 0;
            }

            return response()->json([
                'labels' => $periodos->toArray(),
                'ingresos' => $ingresosArray,
                'gastos' => $gastosArray,
                'groupedBy' => $groupByDay ? 'day' : 'month'
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error en rentabilidad: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function generateRentabilidad(Request $request)
    {
        try {
            $fechaInicio = $request->input('fecha_inicio');
            $fechaFin = $request->input('fecha_fin');
            $articulosParam = $request->input('articulos');

            // Reuse logic or call internal method? Re-implementing for PDF context to keep it self-contained
            // or we could extract the logic to a service. For now, adapting the logic for PDF view.
            
            $articulosIds = !empty($articulosParam) ? $articulosParam : []; // Form sends array directly if checkboxes

            $dbDriver = DB::connection()->getDriverName();
            $dateFormat = $dbDriver === 'sqlite' ? 'strftime("%Y-%m-%d", factura.fecha_emision)' : 'DATE_FORMAT(factura.fecha_emision, "%Y-%m-%d")';
            $dateFormatCompra = $dbDriver === 'sqlite' ? 'strftime("%Y-%m-%d", fecha_compra)' : 'DATE_FORMAT(fecha_compra, "%Y-%m-%d")';

            // Ingresos
            $queryIngresos = DB::table('factura')
                ->where('factura.estado', '!=', 'anulado')
                ->whereBetween('factura.fecha_emision', [$fechaInicio, $fechaFin]);

            if (!empty($articulosIds)) {
                $ingresosData = $queryIngresos
                    ->join('detalle_factura', 'factura.id', '=', 'detalle_factura.cod_factura')
                    ->whereIn('detalle_factura.cod_articulo', $articulosIds)
                    ->select(DB::raw("$dateFormat as periodo"), DB::raw('sum(detalle_factura.total) as ingresos'))
                    ->groupBy('periodo')
                    ->orderBy('periodo')
                    ->get();
            } else {
                $ingresosData = $queryIngresos
                    ->select(DB::raw("$dateFormat as periodo"), DB::raw('sum(factura.total_factura) as ingresos'))
                    ->groupBy('periodo')
                    ->orderBy('periodo')
                    ->get();
            }

            // Gastos
            $gastosQuery = DB::table('compra')
                ->select(DB::raw("$dateFormatCompra as periodo"), DB::raw('sum(precio_compra * cantidad) as gastos'))
                ->whereBetween('fecha_compra', [$fechaInicio, $fechaFin]);

            if (!empty($articulosIds)) {
                $gastosQuery->whereIn('cod_articulo', $articulosIds);
            }

            $gastosData = $gastosQuery
                ->groupBy('periodo')
                ->orderBy('periodo')
                ->get();

            // Merge for table view
            $periodos = $ingresosData->pluck('periodo')->merge($gastosData->pluck('periodo'))->unique()->sort()->values();
            $reportData = [];
            
            $totalIngresos = 0;
            $totalGastos = 0;

            foreach ($periodos as $periodo) {
                $ingreso = $ingresosData->firstWhere('periodo', $periodo);
                $gasto = $gastosData->firstWhere('periodo', $periodo);
                
                $ingresoAmount = $ingreso ? (float)$ingreso->ingresos : 0;
                $gastoAmount = $gasto ? (float)$gasto->gastos : 0;
                
                $totalIngresos += $ingresoAmount;
                $totalGastos += $gastoAmount;

                $reportData[] = [
                    'fecha' => $periodo,
                    'ingresos' => $ingresoAmount,
                    'gastos' => $gastoAmount,
                    'beneficio' => $ingresoAmount - $gastoAmount
                ];
            }

            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('reportes.pdf.rentabilidad', [
                'data' => $reportData,
                'fechaInicio' => $fechaInicio,
                'fechaFin' => $fechaFin,
                'totalIngresos' => $totalIngresos,
                'totalGastos' => $totalGastos,
                'totalBeneficio' => $totalIngresos - $totalGastos,
                'filtros' => !empty($articulosIds) ? 'Artículos seleccionados' : 'Todos los artículos'
            ]);

            return $pdf->download('reporte-rentabilidad.pdf');

        } catch (\Exception $e) {
            return back()->with('error', 'Error al generar el reporte: ' . $e->getMessage());
        }
    }
}
