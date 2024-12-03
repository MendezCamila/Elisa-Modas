<!DOCTYPE html>
<html>
<head>
    <title>Ventas</title>
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
    <h1>Ventas</h1>
    <table>
        <thead>
            <tr>
                <th>Nº venta</th>
                <th>F. venta</th>
                <th>ID Cliente</th>
                <th>Cliente</th>
                <th>Nº de operación</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ventas as $venta)
                <tr>
                    <td>{{ $venta->id }}</td>
                    <td>{{ $venta->created_at->format('d/m/Y') }}</td>
                    <td>{{ $venta->user_id }}</td>
                    <td>{{ $venta->user ? $venta->user->name . ' ' . $venta->user->last_name : 'No asignado' }}</td>
                    <td>{{ $venta->payment_id }}</td>
                    <td>${{ number_format($venta->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
