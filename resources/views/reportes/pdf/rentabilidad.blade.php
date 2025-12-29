<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Rentabilidad</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; color: #166866; }
        .info { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; color: #166866; }
        .text-end { text-align: right; }
        .text-center { text-align: center; }
        .fw-bold { font-weight: bold; }
        .text-success { color: #198754; }
        .text-danger { color: #dc3545; }
        .summary { margin-top: 20px; border-top: 2px solid #166866; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Reporte de Rentabilidad</h1>
        <p>Sistema de Facturación Avanzada</p>
    </div>

    <div class="info">
        <p><strong>Fecha Generación:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        <p><strong>Periodo:</strong> {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}</p>
        <p><strong>Filtro:</strong> {{ $filtros }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Fecha / Periodo</th>
                <th class="text-end">Ingresos</th>
                <th class="text-end">Gastos</th>
                <th class="text-end">Margen / Beneficio</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $row)
                <tr>
                    <td>{{ $row['fecha'] }}</td>
                    <td class="text-end text-success">S/. {{ number_format($row['ingresos'], 2) }}</td>
                    <td class="text-end text-danger">S/. {{ number_format($row['gastos'], 2) }}</td>
                    <td class="text-end fw-bold {{ $row['beneficio'] >= 0 ? 'text-success' : 'text-danger' }}">
                        S/. {{ number_format($row['beneficio'], 2) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="fw-bold" style="background-color: #e9ecef;">
                <td>TOTAL</td>
                <td class="text-end text-success">S/. {{ number_format($totalIngresos, 2) }}</td>
                <td class="text-end text-danger">S/. {{ number_format($totalGastos, 2) }}</td>
                <td class="text-end {{ $totalBeneficio >= 0 ? 'text-success' : 'text-danger' }}">
                    S/. {{ number_format($totalBeneficio, 2) }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="summary">
        <h3>Resumen Financiero</h3>
        <p>El margen de beneficio neto para el periodo seleccionado es de <strong>S/. {{ number_format($totalBeneficio, 2) }}</strong>.</p>
    </div>
</body>
</html>
