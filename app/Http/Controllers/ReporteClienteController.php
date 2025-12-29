<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteClienteController extends Controller
{
    public function generate(Request $request)
    {
        // Validación básica
        $request->validate([
            'tipo_reporte' => 'required|string|in:compras_monto,compras_cantidad,actividad_frecuencia,inactivos',
            'periodo' => 'required|string|in:dia,semana,mes,anio,personalizado',
            'limite' => 'required|string|in:5,10,20,50,todos',
        ]);

        $tipoReporte = $request->tipo_reporte;
        $periodo = $request->periodo;
        $fechaInicio = null;
        $fechaFin = null;

        // Lógica de fechas según periodo
        switch ($periodo) {
            case 'dia':
                $fecha = $request->fecha_dia ? Carbon::parse($request->fecha_dia) : Carbon::now();
                $fechaInicio = $fecha->copy()->startOfDay();
                $fechaFin = $fecha->copy()->endOfDay();
                break;
            case 'semana':
                // Input tipo 'week' devuelve formato "2024-W01"
                if ($request->fecha_semana) {
                    $fechaInicio = Carbon::parse($request->fecha_semana)->startOfWeek();
                    $fechaFin = Carbon::parse($request->fecha_semana)->endOfWeek();
                } else {
                    $fechaInicio = Carbon::now()->startOfWeek();
                    $fechaFin = Carbon::now()->endOfWeek();
                }
                break;
            case 'mes':
                // Input tipo 'month' devuelve "2024-01"
                $fecha = $request->fecha_mes ? Carbon::parse($request->fecha_mes) : Carbon::now();
                $fechaInicio = $fecha->copy()->startOfMonth();
                $fechaFin = $fecha->copy()->endOfMonth();
                break;
            case 'anio':
                $anio = $request->fecha_anio ?? date('Y');
                $fechaInicio = Carbon::createFromDate($anio, 1, 1)->startOfDay();
                $fechaFin = Carbon::createFromDate($anio, 12, 31)->endOfDay();
                break;
            case 'personalizado':
                $fechaInicio = $request->fecha_inicio ? Carbon::parse($request->fecha_inicio)->startOfDay() : null;
                $fechaFin = $request->fecha_fin ? Carbon::parse($request->fecha_fin)->endOfDay() : null;
                break;
        }

        $limite = $request->limite === 'todos' ? null : intval($request->limite);

        $query = Cliente::query()->where('rol', 'client'); // Solo clientes, no admins

        $tituloReporte = '';
        $columnas = [];

        switch ($tipoReporte) {
            case 'compras_monto':
                $tituloReporte = 'Top Clientes por Monto de Compra';
                $query->withSum(['facturas as total_compras' => function ($q) use ($fechaInicio, $fechaFin) {
                    $q->where('estado', 'activo');
                    if ($fechaInicio) $q->where('fecha_emision', '>=', $fechaInicio);
                    if ($fechaFin) $q->where('fecha_emision', '<=', $fechaFin);
                }], 'total_factura')
                ->orderByDesc('total_compras');
                break;

            case 'compras_cantidad':
                $tituloReporte = 'Top Clientes por Cantidad de Artículos Comprados';
                // Esta consulta es mas compleja pq requiere joins con detalles, simplificaremos por ahora contando facturas o idealmente implementando un scope mas avanzado
                // Para simplificar y ser eficientes, usaremos cantidad de facturas como proxy de actividad volumnétrica o subtotal acumulado si no tenemos cantidad directa facil
                // Re-leemos requerimiento: "mas productos compra". Necesitamos sumar cantidad de los detalles de las facturas del cliente.
                $query->withSum(['facturas as total_articulos' => function ($q) use ($fechaInicio, $fechaFin) {
                        $q->where('estado', 'activo');
                        if ($fechaInicio) $q->where('fecha_emision', '>=', $fechaInicio);
                        if ($fechaFin) $q->where('fecha_emision', '<=', $fechaFin);
                        // Esto requeriría un join con detalle_factura, Eloquent no tiene withSum anidado directo facil sin relaciones proper
                        // Vamos a aproximar con Nro de Facturas para "Más Activo" y Monto para "Más Gasta".
                        // Para "Más productos" necesitamos relación hasManyThrough o similar.
                        // Asumiremos que el usuario aceptará Cantidad de Facturas como "Más Activo" y Monto como "Más Gasta".
                        // Para "Más productos" intentaremos una subquery si es posible, o lo manejamos igual que monto por ahora.
                }], 'total_factura'); // Placeholder, see logic below
                
                // Correction: Let's implement generic logic first.
                // "Más productos compra" -> Suma de cantidades en detalle_factura.
                // "Más gasta" -> Suma de total_factura (Implementado arriba).
                // "Más activo" -> Conteo de facturas.
                break;

            case 'actividad_frecuencia':
                $tituloReporte = 'Clientes Más Activos (Frecuencia de Compra)';
                $query->withCount(['facturas as total_transacciones' => function ($q) use ($fechaInicio, $fechaFin) {
                    $q->where('estado', 'activo');
                    if ($fechaInicio) $q->where('fecha_emision', '>=', $fechaInicio);
                    if ($fechaFin) $q->where('fecha_emision', '<=', $fechaFin);
                }])
                ->orderByDesc('total_transacciones');
                break;

            case 'inactivos':
                $tituloReporte = 'Clientes Inactivos (Sin Compras en el Periodo)';
                $query->whereDoesntHave('facturas', function ($q) use ($fechaInicio, $fechaFin) {
                    $q->where('estado', 'activo');
                    if ($fechaInicio) $q->where('fecha_emision', '>=', $fechaInicio);
                    if ($fechaFin) $q->where('fecha_emision', '<=', $fechaFin);
                });
                break;
        }

        // Apply limit if not 'inactivos' (inactivos list might be long, but usually we want to see them all or paginated, PDF has no pagination logic yet so limit is good reliability)
        if ($limite) {
            $query->limit($limite);
        }

        $clientes = $query->get();

        // Data post-processing for complex metrics like "Quantity of products" if Eloquent sum was too hard inline
        if ($tipoReporte === 'compras_cantidad') {
            // "Más productos compra"
            // We need to iterate or use a raw query. Eloquent approach:
            // Cliente -> hasMany Factura -> hasMany DetalleFactura
            // We want Sum(DetalleFactura.cantidad)
            // Efficient approach: Load relationships and sum in PHP (Okay for limited result set) or Raw Query.
            // Let's use a modified query for this specific case to be performant.
            $tituloReporte = 'Top Clientes por Cantidad de Productos Comprados';
             // Re-build query for this specific hard case
             $clientes = Cliente::where('rol', 'client')
                ->with(['facturas' => function($q) use ($fechaInicio, $fechaFin) {
                    $q->where('estado', 'activo');
                    if ($fechaInicio) $q->where('fecha_emision', '>=', $fechaInicio);
                    if ($fechaFin) $q->where('fecha_emision', '<=', $fechaFin);
                    $q->with('detalles');
                }])->get();
            
            // Calculate manually and sort
            $clientes->map(function($cliente) {
                $cliente->total_productos = $cliente->facturas->flatMap->detalles->sum('cantidad');
                return $cliente;
            });
            $clientes = $clientes->sortByDesc('total_productos')->values();
            if ($limite) $clientes = $clientes->take($limite);
        }

        $pdf = Pdf::loadView('clientes.pdf.reporte_general', compact('clientes', 'tipoReporte', 'fechaInicio', 'fechaFin', 'tituloReporte'));
        
        return $pdf->stream('reporte_clientes.pdf');
    }
}
