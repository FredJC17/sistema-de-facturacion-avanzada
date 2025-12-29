<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReporteVentaController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'tipo_reporte' => 'required|string|in:ventas_periodo,promedio_ticket',
            'periodo' => 'required|string|in:dia,semana,mes,anio,personalizado',
        ]);

        $tipoReporte = $request->tipo_reporte;
        $periodo = $request->periodo;
        $fechaInicio = null;
        $fechaFin = null;

        // Date Logic (Copied from Client Report for consistency)
        switch ($periodo) {
            case 'dia':
                $fecha = $request->fecha_dia ? Carbon::parse($request->fecha_dia) : Carbon::now();
                $fechaInicio = $fecha->copy()->startOfDay();
                $fechaFin = $fecha->copy()->endOfDay();
                break;
            case 'semana':
                if ($request->fecha_semana) {
                    $fechaInicio = Carbon::parse($request->fecha_semana)->startOfWeek();
                    $fechaFin = Carbon::parse($request->fecha_semana)->endOfWeek();
                } else {
                    $fechaInicio = Carbon::now()->startOfWeek();
                    $fechaFin = Carbon::now()->endOfWeek();
                }
                break;
            case 'mes':
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

        $tituloReporte = '';
        $ventas = collect();
        $totalGeneral = 0;

        if ($tipoReporte === 'ventas_periodo') {
            $tituloReporte = 'Reporte de Ventas por Período';
            // Agrupar por fecha
            $ventas = Factura::selectRaw('DATE(fecha_emision) as fecha, COUNT(*) as cantidad, SUM(total_factura) as total')
                ->where('estado', 'activo')
                ->whereBetween('fecha_emision', [$fechaInicio, $fechaFin])
                ->groupBy('fecha')
                ->orderBy('fecha')
                ->get();
            
            $totalGeneral = $ventas->sum('total');

        } elseif ($tipoReporte === 'promedio_ticket') {
            $tituloReporte = 'Reporte de Ticket Promedio';
            // Listado de facturas con su total para ver distribución
            $ventas = Factura::where('estado', 'activo')
                ->whereBetween('fecha_emision', [$fechaInicio, $fechaFin])
                ->with('cliente')
                ->orderByDesc('total_factura')
                ->get();
            
            $totalGeneral = $ventas->avg('total_factura');
        }

        $pdf = Pdf::loadView('reportes.pdf.ventas', compact('ventas', 'tipoReporte', 'fechaInicio', 'fechaFin', 'tituloReporte', 'totalGeneral'));
        return $pdf->stream('reporte_ventas.pdf');
    }
}
