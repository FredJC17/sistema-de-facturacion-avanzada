<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use Barryvdh\DomPDF\Facade\Pdf;

class ReporteArticuloController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'tipo_reporte' => 'required|string|in:stock_bajo,mas_vendidos,valor_inventario',
            'limite' => 'required|string|in:5,10,20,50,todos',
        ]);

        $tipoReporte = $request->tipo_reporte;
        $limite = $request->limite === 'todos' ? null : intval($request->limite);

        $query = Articulo::query();
        $tituloReporte = '';

        switch ($tipoReporte) {
            case 'stock_bajo':
                $tituloReporte = 'Reporte de Stock Crítico (<= 10)';
                $query->where('stock', '<=', 10)->orderBy('stock', 'asc');
                break;

            case 'mas_vendidos':
                $tituloReporte = 'Artículos Más Vendidos';
                $query->withSum('detalleFacturas as total_vendido', 'cantidad')
                      ->orderByDesc('total_vendido');
                break;

            case 'valor_inventario':
                $tituloReporte = 'Valoración de Inventario';
                // Calculamos valor: costo * stock
                // Eloquent sorting by computed column requires raw or collection sort.
                // Doing DB raw for efficiency.
                $query->selectRaw('*, (precio_costo * stock) as valor_total')
                      ->orderByDesc('valor_total');
                break;
        }

        if ($limite) {
            $query->limit($limite);
        }

        $articulos = $query->get();

        $pdf = Pdf::loadView('reportes.pdf.articulos', compact('articulos', 'tipoReporte', 'tituloReporte'));
        return $pdf->stream('reporte_articulos.pdf');
    }
}
