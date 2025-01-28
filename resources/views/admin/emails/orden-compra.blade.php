<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Orden de Compra</title>
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
            background-color: #1b89d0;
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
            color: #1b89d0;
            text-decoration: none;
            font-weight: bold;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #aaaaaa;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            Elisa Modas - Orden de Compra
        </div>
        <div class="body">
            <p>Estimado proveedor,</p>

            <p>Se le ha generado una nueva orden de compra. A continuación, encontrará algunos detalles básicos:</p>

            <p><strong>Orden de Compra #:</strong> {{ $ordenCompra->id }}</p>
            <p><strong>Estado:</strong> {{ $ordenCompra->estado }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $ordenCompra->created_at->format('d/m/Y') }}</p>

            <p>Para visualizar todos los detalles y gestionar esta orden, haga clic en el siguiente enlace:</p>
            <a href="{{ url('admin/orden-compras/' . $ordenCompra->id) }}" target="_blank">Ver Orden de Compra</a>

            <p>Gracias por colaborar con nosotros,</p>
            <p>El equipo de Elisa Modas</p>
        </div>
        <div class="footer">
            &copy; 2025 Elisa Modas. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
