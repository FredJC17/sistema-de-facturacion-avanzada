<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class ReporteProveedorController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'tipo_reporte' => 'required|string|in:proveedores_stock,proveedores_ubicacion',
            'periodo' => 'nullable|string', // Proveedores is mostly snapshot based, but keeping for consistency if needed later
            'limite' => 'required|string|in:5,10,20,50,todos',
        ]);

        $tipoReporte = $request->tipo_reporte;
        $limite = $request->limite === 'todos' ? null : intval($request->limite);

        $query = Proveedor::query();
        $tituloReporte = '';

        switch ($tipoReporte) {
            case 'proveedores_stock':
                $tituloReporte = 'Top Proveedores por Variedad de Artículos';
                $query->withCount('articulos')->orderByDesc('articulos_count');
                break;

            case 'proveedores_ubicacion':
                $tituloReporte = 'Proveedores por Ubicación (Ciudad)';
                $query->with('ciudad')->orderBy('cod_ciudad'); 
                // Grouping is better doing in collection or view for simple lists, 
                // but direct list ordered by city is fine for PDF report.
                break;
        }

        if ($limite) {
            $query->limit($limite);
        }

        $proveedores = $query->get();

        $pdf = Pdf::loadView('reportes.pdf.proveedores', compact('proveedores', 'tipoReporte', 'tituloReporte'));
        return $pdf->stream('reporte_proveedores.pdf');
    }
}
