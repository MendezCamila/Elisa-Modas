<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Producto Disponible</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            background: #343a40;
            color: #ffffff;
            padding: 15px;
            font-size: 18px;
            border-radius: 8px 8px 0 0;
        }
        .content {
            padding: 20px;
            color: #333;
        }
        .button {
            display: inline-block;
            padding: 10px 15px;
            background: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .details {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <strong>Producto Disponible</strong>
        </div>
        <div class="content">
            <p>Hola <strong>{{ $reserva->user->name }}</strong>,</p>

            <p>El producto que reservaste ya llegó a nuestro inventario.</p>

            {{--
            <div class="details">
                <strong>Detalles de la reserva:</strong><br>
                Producto: <strong>{{ $reserva->preVenta->variant->product->name }}</strong><br>
                Cantidad: <strong>{{ $reserva->cantidad }}</strong><br>
                Precio unitario: <strong>${{ number_format($reserva->preVenta->variant->product->price, 2, ',', '.') }}</strong><br>
                Total a pagar: <strong>${{ number_format($reserva->cantidad * $reserva->preVenta->variant->product->price, 2, ',', '.') }}</strong>
            </div>--}}
            <div class="details">
                <ul>
                    <li><strong>Producto:</strong> {{ $reserva->preventa->variant->product->name }}</li>
                    <li><strong>Cantidad:</strong> {{ $reserva->cantidad }}</li>
                    <li><strong>Precio unitario:</strong> ${{ number_format($reserva->preventa->variant->product->price * (1 - $reserva->preventa->descuento / 100), 2) }}</li>
                    <li class="total"><strong>Total a pagar:</strong> ${{ number_format(($reserva->preventa->variant->product->price * (1 - $reserva->preventa->descuento / 100)) * $reserva->cantidad, 2) }}</li>
                </ul>
            </div>

            <p>
                <strong>Para pagar en línea:</strong><br>
                Haz clic en el siguiente enlace para completar tu pago a través de Mercado Pago:<br>
                <a href="{{ route('reservation.onlinePayment', $reserva->id) }}" class="button">Pagar en línea</a>
            </p>

            <p>
                <strong>Si prefieres pagar en el local:</strong><br>
                Preséntate en nuestra tienda y menciona tu reserva con el <strong>ID {{ $reserva->id }}</strong>.
                Tienes un plazo de <strong>4 días hábiles</strong> a partir de la fecha de este correo para retirar tu producto.
                La reserva se mantendrá pendiente hasta que el administrador la marque como pagada.
            </p>

            <p>Gracias por confiar en nosotros.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Elisa Modas. Todos los derechos reservados.
        </div>
    </div>

</body>
</html>
