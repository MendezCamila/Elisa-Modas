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
            color #333;
        }

        .ticket {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
        }

        h1, h2, h3, h4 {
            text-align: center;
            margin-bottom: 10px 0;
        }

        .section {
            margin-bottom: 20px;
        }

        .section-header {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 5px;
        }

        .info div {
            margin-bottom: 5px;
        }

        .products table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .products th, .products td {
            border-bottom: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        .products th {
            background-color:#f9f9f9;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 10px;
        }


        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
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



        {{-- Info de la empresa --}}
        <div class="section">
            <div class="section-header">Información de la empresa</div>
            <div><strong>Nombre:</strong> Elisa Modas</div>
            <div><strong>Dirección:</strong> Juan Manuel de Rosas 669</div>
            <div><strong>Teléfono:</strong> 3756458015</div>
            <div><strong>Email:</strong> info@elisamodas.com</div>
        </div>



        {{-- Info del cliente --}}
        <div class="section">
            <div class="section-header">Datos del cliente</div>
            <div><strong>Nombre:</strong> {{ $venta->user->name }}</div>
            <div><strong>Apellido:</strong> {{ $venta->user->last_name }}</div>
            <div><strong>Teléfono:</strong> {{ $venta->user->phone }}</div>
            <div><strong>Email:</strong> {{ $venta->user->email }}</div>
        </div>

        <div class="separator"></div>

        {{-- Productos comprados --}}
        <div class="section">
            <div class="section-header">Productos comprados</div>
            <table class="products">
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
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>${{ number_format($item['subtotal'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



        {{-- Total de la venta --}}
        <div class="section total">
            Total: ${{ number_format($venta->total, 2) }}
        </div>

        <div class="separator"></div>

        <!-- Footer -->
        <div class="footer">
            ¡Gracias por tu compra!<br>
            Página 1
        </div>
    </div>
</body>
</html>
