<!DOCTYPE html>
<html>
<head>
    <title>Informe de Órdenes de Compra - Elisa Modas</title>
    <style>
        @page {
            margin-top: 100px; /* Ajusta el margen superior para evitar superposición */
            margin-bottom: 50px;
        }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        .header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            text-align: center;
            padding-bottom: 5px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            border-top: 1px solid #333;
            padding-top: 5px;
        }
        .content {
            margin-top: 20px;
        }
        .filters {
            margin-top: 20px;
            font-size: 12px;
            border: 1px solid #333;
            padding: 10px;
            background-color: #f9f9f9;
            border-radius: 5px;
            page-break-inside: avoid;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            display: table-header-group; /* Para que el encabezado se repita en cada página */
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f0f0f0;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .pagenum:before {
            content: counter(page);
        }
    </style>
</head>
<body>

    <!-- Encabezado -->
    <div class="header">
        <h1>Elisa Modas</h1>
    </div>

    <div class="content">
        <!-- Filtros Aplicados y Fecha de Generación -->
        <div class="filters">
            <h3>Filtros Aplicados:</h3>
            <ul>
                @if(isset($filters['supplier_id']))
                    <li>Proveedor: {{ \App\Models\Supplier::find($filters['supplier_id'])->name ?? 'No especificado' }} {{ \App\Models\Supplier::find($filters['supplier_id'])->last_name ?? '' }}</li>
                @endif

                @if(isset($filters['rango_de_fechas']['minDate']) && isset($filters['rango_de_fechas']['maxDate']))
                    <li>Rango de Fechas: {{ $filters['rango_de_fechas']['minDate'] }} hasta {{ $filters['rango_de_fechas']['maxDate'] }}</li>
                @endif

                @if(empty($filters))
                    <li>No se aplicaron filtros</li>
                @endif
            </ul>
            <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
        </div>

        <!-- Tabla de Órdenes de Compra -->
        <table>
            <thead>
                <tr>
                    <th># Orden</th>
                    <th>Proveedor</th>
                    <th>Estado</th>
                    <th>Fecha de Creación</th>
                    <th>Producto</th>
                    <th>Variante</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ordenesCompra as $ordenCompra)
                    @foreach ($ordenCompra->detalleOrdenCompras as $detalle)
                        <tr>
                            <td>{{ $ordenCompra->id }}</td>
                            <td>{{ $ordenCompra->proveedor->name ?? 'No disponible' }} {{ $ordenCompra->proveedor->last_name ?? '' }}</td>
                            <td>{{ $ordenCompra->estado }}</td>
                            <td>{{ $ordenCompra->created_at->format('d/m/Y') }}</td>
                            <td>{{ $detalle->variant->product->name ?? 'Producto no disponible' }}</td>
                            <td>{{ $detalle->variant->sku ?? 'Variante no disponible' }}</td>
                            <td>{{ $detalle->cantidad }}</td>
                            <td>{{ number_format($detalle->precio_unitario, 2) }}</td>
                            <td>{{ number_format($detalle->total, 2) }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pie de página con numeración -->
    <div class="footer">
        Página <span class="pagenum"></span>
    </div>

    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_text(520, 820, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
        }
    </script>

</body>
</html>
