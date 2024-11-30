<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ticket de compra</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 14px;
        }

        .ticket {
            max-width: 400px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1, h2, h3, h4 {
            text-align: center;
            margin-bottom: 10px;
        }

        .info, .products, .total, .footer {
            margin-bottom: 10px;
        }

        .info div, .products div, .total div, .footer div {
            margin-bottom: 5px;
        }

        .products table {
            width: 100%;
            border-collapse: collapse;
        }

        .products th, .products td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        .products th {
            background-color: #f2f2f2;
        }

        .total {
            text-align: right;
            font-size: 16px;
            font-weight: bold;
        }

        .footer {
            text-align: center;
            font-size: 12px;
        }

        .page-break {
            page-break-after: always;
        }

        .page-number:after {
            content: counter(page);
        }

        @page {
            margin: 20px;
            @bottom-right {
                content: "Página " counter(page);
            }
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo h1 {
            margin: 0;
            font-size: 24px;
            color: #000; /* Cambia el color según sea necesario */
            position: relative;
        }

        .logo h1 span {
            display: block;
            font-size: 12px;
            color: #666; /* Cambia el color según sea necesario */
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            top: 100%;
        }

        .separator {
            border-top: 1px solid #ccc;
            margin: 10px 0;
        }

        .bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="ticket">
        <div class="logo">
            <h1>
                Elisa Modas
            </h1>
        </div>

        <h4 class="bold">Número de venta: {{ $venta->id }}</h4>
        <div class="bold">Fecha: {{ $venta->created_at->format('d/m/Y') }}</div>

        <div class="separator"></div>

        {{-- Info de la empresa --}}
        <div class="info">
            <h3>Información de la empresa</h3>
            <div><span class="bold">Nombre:</span> Elisa Modas</div>
            <div><span class="bold">Dirección:</span> Juan Manuel de Rosas 669</div>
            <div><span class="bold">Teléfono:</span> 3756458015</div>
            <div><span class="bold">Email:</span> info@elisamodas.com</div>
        </div>

        <div class="separator"></div>

        {{-- Info del cliente --}}
        <div class="info">
            <h3>Datos del cliente</h3>
            <div><span class="bold">Nombre:</span> {{ $venta->user->name }}</div>
            <div><span class="bold">Apellido:</span> {{ $venta->user->last_name }}</div>
            <div><span class="bold">Teléfono:</span> {{ $venta->user->phone }}</div>
            <div><span class="bold">Email:</span> {{ $venta->user->email }}</div>
        </div>

        <div class="separator"></div>

        {{-- Productos comprados --}}
        <div class="products">
            <h3>Productos comprados</h3>
            <table>
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->content as $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['qty'] }}</td>
                            <td>{{ number_format($item['price'], 2) }}</td>
                            <td>{{ number_format($item['subtotal'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="separator"></div>

        {{-- Total de la venta --}}
        <div class="total">
            <span class="bold">Total:</span> ${{ number_format($venta->total, 2) }}
        </div>

        <div class="separator"></div>

        <div class="footer">
            ¡Gracias por tu compra!
        </div>
    </div>

    <div class="footer">
        Página <span class="page-number"></span>
    </div>
</body>
</html>
