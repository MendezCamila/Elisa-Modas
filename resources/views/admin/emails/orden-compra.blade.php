{{-- filepath: /C:/xampp/htdocs/laravel/elisamodas/resources/views/admin/emails/orden-compra.blade.php --}}
{{-- filepath: /C:/xampp/htdocs/laravel/elisamodas/resources/views/admin/emails/orden-compra.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Nueva Orden de Compra</title>
</head>
<body>
    <h1>Orden de Compra #{{ $ordenCompra->id }}</h1>
    <p><strong>Proveedor:</strong> {{ $ordenCompra->proveedor->name }}</p>
    <p><strong>Estado:</strong> {{ $ordenCompra->estado }}</p>
    <p><strong>Fecha de Creación:</strong> {{ $ordenCompra->created_at->format('d/m/Y') }}</p>

    <h2>Detalles</h2>
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
</body>
</html>
