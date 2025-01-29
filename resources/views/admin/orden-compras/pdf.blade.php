<!DOCTYPE html>
<html>
<head>
    <title>Ordenes de Compra</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Ordenes de Compra</h1>
    @foreach ($ordenesCompra as $ordenCompra)
        <h2>Orden de Compra #{{ $ordenCompra->id }}</h2>
        <p><strong>Proveedor:</strong> {{ $ordenCompra->proveedor->name }} {{ $ordenCompra->proveedor->last_name }}</p>
        <p><strong>Estado:</strong> {{ $ordenCompra->estado }}</p>
        <p><strong>Fecha de Creación:</strong> {{ $ordenCompra->created_at->format('d/m/Y') }}</p>
        <p><strong>Fecha de Actualización:</strong> {{ $ordenCompra->updated_at->format('d/m/Y') }}</p>

        <h3>Detalles de la Orden de Compra</h3>
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
                        <td>{{ $detalle->precio_unitario }}</td>
                        <td>{{ $detalle->total }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach
</body>
</html>
