<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura {{ $factura->nro_factura }} - SFA</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #fff;
            }
        }
        
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        
        .invoice-header {
            border-bottom: 3px solid #166866;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .company-info {
            text-align: center;
            margin-bottom: 20px;
        }
        
        .company-logo {
            max-width: 120px;
            margin-bottom: 10px;
        }
        
        .invoice-title {
            font-size: 2rem;
            font-weight: bold;
            color: #166866;
        }
        
        .invoice-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .table-invoice {
            margin-top: 20px;
        }
        
        .totals-section {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            border-left: 4px solid #166866;
        }
        
        .total-final {
            background-color: #166866;
            color: white;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }

        .badge-custom {
            background-color: #166866;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Botones de acción (solo visible en pantalla) -->
        @if(!$isPdf)
        <div class="no-print mb-3">
            <button onclick="window.print()" class="btn btn-primary">
                <i class="bi bi-printer"></i> Imprimir
            </button>
            <button onclick="window.close()" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cerrar
            </button>
        </div>
        @endif

        <!-- Encabezado de la empresa -->
        <div class="company-info">
            @if($isPdf)
                <img src="{{ public_path('images/logo/sfa_completo.png') }}" alt="Logo SFA" class="company-logo" style="height: 80px; width: auto;">
            @else
                <img src="{{ asset('images/logo/sfa_completo.png') }}" alt="Logo SFA" class="company-logo" style="height: 80px; width: auto;">
            @endif
            <h1 class="invoice-title">SISTEMA DE FACTURACIÓN AVANZADA</h1>
            <p class="mb-0"><i class="bi bi-building"></i> RUC: 20123456789</p>
            <p class="mb-0 text-uppercase"><i class="bi bi-geo-alt"></i> Calle Ulrich Neisser 106 URB. Simon Bolivar, Arequipa - Peru</p>
            <p class="mb-0"><i class="bi bi-telephone"></i> (01) 123-4567 | <i class="bi bi-envelope"></i> contacto@sfa.com.pe</p>
        </div>

        <div class="invoice-header">
            <div class="row">
                <div class="col-md-6">
                    <h3><i class="bi bi-receipt"></i> FACTURA ELECTRÓNICA</h3>
                    <p><strong>Nro. Factura:</strong> <span class="badge-custom">{{ $factura->nro_factura }}</span></p>
                    <p><strong>Fecha Emisión:</strong> {{ \App\Helpers\FormatoHelper::formatearFecha($factura->fecha_emision) }}</p>
                    <p><strong>Fecha Facturación:</strong> {{ \App\Helpers\FormatoHelper::formatearFecha($factura->fecha_facturacion) }}</p>
                    <p><strong>Estado:</strong> {!! \App\Helpers\FormatoHelper::badgeEstado($factura->estado) !!}</p>
                </div>
                <div class="col-md-6">
                    <h4><i class="bi bi-person-circle"></i> DATOS DEL CLIENTE</h4>
                    <p><strong>{{ $factura->cliente->getNombreCompleto() }}</strong></p>
                    <p>{{ $factura->cliente->tipoDocumento->descripcion_tipo_doc }}: {{ $factura->cliente->documento }}</p>
                    <p><i class="bi bi-envelope"></i> {{ $factura->cliente->email }}</p>
                    <p><i class="bi bi-telephone"></i> {{ $factura->cliente->telefono ?? 'N/A' }}</p>
                    <p><i class="bi bi-house"></i> {{ $factura->cliente->direccion ?? 'N/A' }}</p>
                    <p><i class="bi bi-geo-alt-fill"></i> {{ $factura->cliente->ciudad->descripcion_ciudad ?? 'N/A' }}</p>
                </div>
            </div>
        </div>

        <!-- Detalle de artículos -->
        <h4 class="mb-3"><i class="bi bi-box-seam"></i> DETALLE DE PRODUCTOS</h4>
        <table class="table table-bordered table-invoice">
            <thead style="background-color: #166866; color: white;">
                <tr>
                    <th width="5%">#</th>
                    <th width="35%">Producto</th>
                    <th width="15%">Tipo</th>
                    <th width="15%" class="text-end">Precio Unit.</th>
                    <th width="10%" class="text-center">Cantidad</th>
                    <th width="20%" class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($factura->detalles as $index => $detalle)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td><strong>{{ $detalle->articulo->descripcion }}</strong></td>
                        <td><small>{{ $detalle->articulo->tipoArticulo->descripcion_articulo }}</small></td>
                        <td class="text-end">{{ \App\Helpers\FormatoHelper::formatearMoneda($detalle->articulo->precio_venta) }}</td>
                        <td class="text-center"><span class="badge bg-secondary">{{ $detalle->cantidad }}</span></td>
                        <td class="text-end"><strong>{{ \App\Helpers\FormatoHelper::formatearMoneda($detalle->total) }}</strong></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Resumen de totales -->
        <div class="row">
            <div class="col-md-6 offset-md-6">
                <div class="totals-section">
                    <!-- Subtotal -->
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                        <span><i class="bi bi-calculator"></i> Subtotal:</span>
                        <strong class="fs-5">{{ \App\Helpers\FormatoHelper::formatearMoneda($factura->subtotal) }}</strong>
                    </div>

                    <!-- IGV 18% -->
                    <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                        <span><i class="bi bi-receipt"></i> IGV (18%):</span>
                        <strong class="fs-5">{{ \App\Helpers\FormatoHelper::formatearMoneda($factura->igv) }}</strong>
                    </div>

                    <!-- Total -->
                    <div class="total-final">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0"><i class="bi bi-cash-coin"></i> TOTAL A PAGAR:</h4>
                            <h3 class="mb-0 fw-bold">{{ \App\Helpers\FormatoHelper::formatearMoneda($factura->total_factura) }}</h3>
                        </div>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="mt-3 p-3" style="background-color: #f8f9fa; border-radius: 5px;">
                    <p class="mb-1 small"><i class="bi bi-box-seam"></i> Total de productos: <strong>{{ $factura->detalles->count() }}</strong></p>
                    <p class="mb-0 small"><i class="bi bi-stack"></i> Total de unidades: <strong>{{ $factura->detalles->sum('cantidad') }}</strong></p>
                </div>
            </div>
        </div>

        <!-- Pie de página -->
        <div class="mt-5 pt-4 border-top text-center">
            <p class="mb-1"><strong>¡Gracias por su preferencia!</strong></p>
            <p class="mb-1"><small>Este documento es una representación impresa de la factura electrónica</small></p>
            <p class="mb-0"><small class="text-muted">Generado el {{ \App\Helpers\FormatoHelper::formatearFechaHora(now()) }}</small></p>
            <p class="mt-3 mb-0"><small>Sistema de Facturación Avanzada (SFA) - © {{ date('Y') }}</small></p>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
