<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Proveedores</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #198754; padding-bottom: 10px; }
        .header h1 { color: #198754; margin: 0; font-size: 24px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #198754; color: white; padding: 10px; text-align: left; }
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
                <th width="30%">Proveedor</th>
                <th width="20%">Documento</th>
                <th width="20%">Ciudad</th>
                <th width="15%">Teléfono</th>
                <th width="15%" class="text-right">
                    @if($tipoReporte == 'proveedores_stock') Arts. Registrados
                    @else Estado
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($proveedores as $prov)
                <tr>
                    <td>{{ $prov->getNombreCompleto() }}</td>
                    <td>{{ $prov->nro_documento }}</td>
                    <td>{{ $prov->ciudad->nombre ?? 'N/A' }}</td>
                    <td>{{ $prov->telefono ?? 'N/A' }}</td>
                    <td class="text-right">
                        @if($tipoReporte == 'proveedores_stock')
                            <strong>{{ $prov->articulos_count }}</strong>
                        @else
                            {{ ucfirst($prov->estado) }}
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
