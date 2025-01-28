<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Compra #{{ $ordenCompra->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1, h2, h4 {
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Orden de Compra #{{ $ordenCompra->id }}</h1>
        <p><strong>Proveedor:</strong> {{ $ordenCompra->proveedor->name }}</p>
        <p><strong>Estado:</strong> {{ $ordenCompra->estado }}</p>
        <p><strong>Fecha de Creación:</strong> {{ $ordenCompra->created_at->format('d/m/Y') }}</p>

        <h4>Detalles de la Orden</h4>
        <table>
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Variante</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ordenCompra->detalleOrdenCompras as $detalle)
                <tr>
                    <td>{{ $detalle->variant->product->name ?? 'Producto no disponible' }}</td>
                    <td>{{ $detalle->variant->sku ?? 'Variante no disponible' }}</td>
                    <td>{{ $detalle->cantidad }}</td>
                    <td>${{ number_format($detalle->precio_unitario, 2) }}</td>
                    <td>${{ number_format($detalle->total, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
