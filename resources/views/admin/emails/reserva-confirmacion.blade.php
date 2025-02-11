<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Confirmación de Reserva</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }
        .header {
            background-color: #d01bb8;
            color: #ffffff;
            padding: 15px;
            text-align: center;
            font-size: 24px;
        }
        .body {
            padding: 20px;
            color: #333333;
            line-height: 1.6;
        }
        .body a {
            color: #d721cb;
            text-decoration: none;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaaaaa;
        }
        .details {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-top: 10px;
        }
        .details li {
            margin-bottom: 8px;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            color: #d01bb8;
        }
        .preventa-info {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 5px;
            border-left: 5px solid #d01bb8;
            margin-bottom: 15px;
            font-size: 16px;
            font-weight: bold;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            Confirmación de Reserva - Elisa Modas
        </div>
        <div class="body">
            <p>Hola {{ $reserva->user->name }},</p>

            <div class="preventa-info">
                📢 <strong>¡Has realizado una reserva en nuestra pre-venta!</strong>
                <br>La pre-venta finaliza el <strong>{{ \Carbon\Carbon::parse($reserva->preventa->fecha_fin)->format('d/m/Y') }}</strong>.
            </div>

            <p>Gracias por reservar el producto <strong>{{ $reserva->preventa->variant->product->name }}</strong>.</p>

            <p><strong>Detalles de la reserva:</strong></p>

            <div class="details">
                <ul>
                    <li><strong>Producto:</strong> {{ $reserva->preventa->variant->product->name }}</li>
                    <li><strong>Cantidad:</strong> {{ $reserva->cantidad }}</li>
                    <li><strong>Precio unitario:</strong> ${{ number_format($reserva->preventa->variant->product->price * (1 - $reserva->preventa->descuento / 100), 2) }}</li>
                    <li class="total"><strong>Total a pagar:</strong> ${{ number_format(($reserva->preventa->variant->product->price * (1 - $reserva->preventa->descuento / 100)) * $reserva->cantidad, 2) }}</li>
                </ul>
            </div>

            <p>Te notificaremos cuando el producto esté disponible para entrega.</p>

            <p>Gracias por confiar en nosotros,</p>
            <p>El equipo de Elisa Modas</p>
        </div>
        <div class="footer">
            &copy; 2025 Elisa Modas. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
