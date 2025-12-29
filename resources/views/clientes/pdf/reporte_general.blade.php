<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Clientes</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #166866;
            padding-bottom: 10px;
        }
        .header h1 {
            color: #166866;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .info-box {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .info-box strong {
            color: #166866;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #166866;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
        }
        td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
        }
        .bg-success { background-color: #198754; }
        .bg-danger { background-color: #dc3545; }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Sistema de Facturación Avanzada</h1>
        <p>Reporte de Análisis de Clientes</p>
    </div>

    <div class="info-box">
        <table style="border: none; margin: 0;">
            <tr style="background: transparent;">
                <td style="border: none; padding: 2px;"><strong>Tipo de Reporte:</strong> {{ $tituloReporte }}</td>
                <td style="border: none; padding: 2px;" class="text-right"><strong>Fecha de Emisión:</strong> {{ date('d/m/Y H:i') }}</td>
            </tr>
            <tr style="background: transparent;">
                <td style="border: none; padding: 2px;">
                    <strong>Filtro de Fechas:</strong> 
                    @if($fechaInicio && $fechaFin)
                        Del {{ $fechaInicio->format('d/m/Y') }} al {{ $fechaFin->format('d/m/Y') }}
                    @elseif($fechaInicio)
                        Desde {{ $fechaInicio->format('d/m/Y') }}
                    @else
                        Histórico Completo
                    @endif
                </td>
                <td style="border: none; padding: 2px;" class="text-right"><strong>Total Registrados:</strong> {{ count($clientes) }}</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">Documento</th>
                <th width="30%">Cliente</th>
                <th width="20%">Ciudad</th>
                <th width="15%" class="text-center">Estado</th>
                <th width="15%" class="text-right">
                    @if($tipoReporte == 'compras_monto') Monto Total
                    @elseif($tipoReporte == 'compras_cantidad') Productos
                    @elseif($tipoReporte == 'actividad_frecuencia') Facturas
                    @else Última Actividad
                    @endif
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse($clientes as $index => $cliente)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $cliente->documento }}</td>
                    <td>
                        {{ $cliente->getNombreCompleto() }}<br>
                        <small style="color: #666;">{{ $cliente->email }}</small>
                    </td>
                    <td>{{ $cliente->ciudad->nombre ?? 'N/A' }}</td>
                    <td class="text-center">
                        <span class="badge {{ $cliente->estaActivo() ? 'bg-success' : 'bg-danger' }}">
                            {{ $cliente->estado }}
                        </span>
                    </td>
                    <td class="text-right">
                        @if($tipoReporte == 'compras_monto')
                            <strong>S/. {{ number_format($cliente->total_compras ?? 0, 2) }}</strong>
                        @elseif($tipoReporte == 'compras_cantidad')
                            <strong>{{ $cliente->total_productos ?? 0 }}</strong>
                        @elseif($tipoReporte == 'actividad_frecuencia')
                            <strong>{{ $cliente->total_transacciones ?? 0 }}</strong>
                        @else
                            {{-- Para inactivos, idealmente mostrar última compra --}}
                            -
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 20px;">
                        No se encontraron datos para los filtros seleccionados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Generado por Sistema de Facturación Avanzada - {{ date('Y') }}
    </div>
</body>
</html>
