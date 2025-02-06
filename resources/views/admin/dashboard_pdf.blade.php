<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas de Ventas - Elisa Modas</title>
    <style>
        @page {
            margin-top: 100px;
            margin-bottom: 50px;
        }
        body {
            font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
            font-size: 12px;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            padding-bottom: 10px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 40px;
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
            margin-top: 60px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        thead {
            display: table-header-group;
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

    <!-- Título -->
    <div class="title">Estadísticas de Ventas</div>

    <div class="content">
        <p><strong>Exportado por:</strong> {{ $user }} {{ $lastName }} | <strong>Fecha de Exportación:</strong> {{ $exportDate }}</p>
        <p><strong>Filtro:</strong></p>
        <p><strong>Desde:</strong> {{ $startDate }} | <strong>Hasta:</strong> {{ $endDate }}</p>

        <h2>Ventas Mensuales</h2>
        <table>
            <thead>
                <tr>
                    <th>Mes</th>
                    <th>Total Ventas</th>
                    <th>Promedio</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ \Carbon\Carbon::create()->month($venta['month'])->translatedFormat('F') }}</td>
                        <td>${{ number_format($venta['total'], 2) }}</td>
                        <td>${{ number_format($venta['average'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2>Subcategorías Más Vendidas</h2>
        <table>
            <thead>
                <tr>
                    <th>Subcategoría</th>
                    <th>Total Unidades Vendidas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($unidadesVendidas as $unidad)
                    <tr>
                        <td>{{ $unidad['subcategory'] }} ({{ $unidad['category'] }} - {{ $unidad['family'] }})</td>
                        <td>{{ $unidad['total'] }}</td>
                    </tr>
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
