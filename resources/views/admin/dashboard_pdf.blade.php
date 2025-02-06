<!DOCTYPE html>
<html>
<head>
    <title>Estadísticas</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h1>Estadísticas de Ventas</h1>
    <p>Desde: {{ $startDate }} Hasta: {{ $endDate }}</p>

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
                    <td>{{ $venta['month'] }}</td>
                    <td>{{ $venta['total'] }}</td>
                    <td>{{ $venta['average'] }}</td>
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
                    <td>{{ $unidad['subcategory'] }}</td>
                    <td>{{ $unidad['total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
