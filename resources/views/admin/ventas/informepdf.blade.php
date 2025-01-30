<!DOCTYPE html>
<html>
<head>
    <title>Informe de Ventas - Elisa Modas</title>
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
            padding-bottom: 10px;
        }
        .title {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-top: 40px; /* Agregado más espacio entre "Elisa Modas" y el título */
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
            margin-top: 60px; /* Aumentado para mayor separación con la cabecera */
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

    <!-- Título Informativo -->
    <div class="title">Informe de Ventas</div>

    <div class="content">
        <!-- Filtros Aplicados y Fecha de Generación -->
        <div class="filters">
            <h3>Filtros Aplicados:</h3>
            <ul>
                @if(isset($filters['cliente_id']))
                    <li>Cliente: {{ \App\Models\User::find($filters['cliente_id'])->name ?? 'No especificado' }} {{ \App\Models\User::find($filters['cliente_id'])->last_name ?? '' }}</li>
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

        <!-- Tabla de Ventas -->
        <table>
            <thead>
                <tr>
                    <th># Venta</th>
                    <th>Cliente</th>
                    <th>Estado</th>
                    <th>Fecha de Creación</th>
                    <th>Contenido</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id }}</td>
                        <td>{{ $venta->user->name ?? 'No disponible' }} {{ $venta->user->last_name ?? '' }}</td>
                        <td>{{ $venta->estado }}</td>
                        <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                        <td>{{ json_encode($venta->content) }}</td>
                        <td>{{ number_format($venta->total, 2) }}</td>
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
