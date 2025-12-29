<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Artículos</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #ffc107; padding-bottom: 10px; }
        .header h1 { color: #d39e00; margin: 0; font-size: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #ffc107; color: #000; padding: 10px; text-align: left; }
        td { padding: 8px 10px; border-bottom: 1px solid #ddd; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema de Facturación Avanzada</h1>
        <p>{{ $tituloReporte }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="40%">Descripción</th>
                <th width="15%">Tipo</th>
                <th width="15%" class="text-right">Precio Venta</th>
                <th width="15%" class="text-right">Stock</th>
                <th width="15%" class="text-right">
                    @if($tipoReporte == 'mas_vendidos') Unidades Vendidas
                    @elseif($tipoReporte == 'valor_inventario') Valor Total
                    @else Estado
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($articulos as $art)
                <tr>
                    <td>{{ $art->descripcion }}</td>
                    <td>{{ $art->tipoArticulo->descripcion_articulo ?? 'N/A' }}</td>
                    <td class="text-right">S/. {{ number_format($art->precio_venta, 2) }}</td>
                    <td class="text-right {{ $art->stock <= 10 ? 'color: red; font-weight: bold;' : '' }}">{{ $art->stock }}</td>
                    <td class="text-right">
                        @if($tipoReporte == 'mas_vendidos')
                            <strong>{{ $art->total_vendido ?? 0 }}</strong>
                        @elseif($tipoReporte == 'valor_inventario')
                            <strong>S/. {{ number_format($art->valor_total, 2) }}</strong>
                        @else
                            {{ ucfirst($art->estado) }}
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" style="text-align: center;">No se encontraron datos.</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
