<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Ventas</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0dcaf0; padding-bottom: 10px; }
        .header h1 { color: #0aa2c0; margin: 0; font-size: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #0dcaf0; color: white; padding: 10px; text-align: left; }
        td { padding: 8px 10px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .text-right { text-align: right; }
        .total-box { background: #e0f7fa; padding: 15px; text-align: right; font-size: 14px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema de Facturación Avanzada</h1>
        <p>{{ $tituloReporte }}</p>
        <small>Del {{ $fechaInicio ? $fechaInicio->format('d/m/Y') : '' }} al {{ $fechaFin ? $fechaFin->format('d/m/Y') : '' }}</small>
    </div>

    @if($tipoReporte == 'ventas_periodo')
        <table>
            <thead>
                <tr>
                    <th width="50%">Fecha</th>
                    <th width="25%" class="text-right">Transacciones</th>
                    <th width="25%" class="text-right">Total Vendido</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha)->format('d/m/Y') }}</td>
                        <td class="text-right">{{ $venta->cantidad }}</td>
                        <td class="text-right">S/. {{ number_format($venta->total, 2) }}</td>
                    </tr>
                @empty
                    <tr><td colspan="3" style="text-align: center;">No se encontraron ventas en este periodo.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="total-box">
            <strong>Ingresos Totales del Periodo: S/. {{ number_format($totalGeneral, 2) }}</strong>
        </div>
    @elseif($tipoReporte == 'promedio_ticket')
        <table>
            <thead>
                <tr>
                    <th width="20%">Nro Factura</th>
                    <th width="40%">Cliente</th>
                    <th width="20%">Fecha</th>
                    <th width="20%" class="text-right">Monto</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ventas as $venta)
                    <tr>
                        <td>{{ $venta->nro_factura }}</td>
                        <td>{{ $venta->cliente->getNombreCompleto() }}</td>
                        <td>{{ \Carbon\Carbon::parse($venta->fecha_emision)->format('d/m/Y') }}</td>
                        <td class="text-right">S/. {{ number_format($venta->total_factura, 2) }}</td>
                    </tr>
                @empty
                     <tr><td colspan="4" style="text-align: center;">No se encontraron ventas.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="total-box">
            <strong>Ticket Promedio: S/. {{ number_format($totalGeneral, 2) }}</strong>
        </div>
    @endif
</body>
</html>
