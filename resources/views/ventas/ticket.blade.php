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
            max-width: 400px ;
            margin: 20px auto;
            padding: 20px;
        }

        h1, h2, h3, h4,  {
            text-align: center;
            margin-bottom: 10px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info div {
            margin-bottom: 5px;
        }

        .footer {
            text-align: center;
            font-size: 12px;
        }

    </style>

</head>
<body>
    <div class="ticket">
        <h4>
            Número de venta: {{ $venta->id }}
        </h4>

        {{-- Info de la empresa --}}
        <div class="info">
            <h3>Información de la empresa</h3>
            <div>
                Nombre: Elisa Modas
            </div>
            <div>
                Dirección: Juan Manuel de rosas 669
            </div>
            <div>
                Teléfono: 3756458015
            </div>
            <div>
                Email: info@elisamodas.com
            </div>

        </div>

        {{-- Info del cliente --}}
        <div class="info">
            <h3>Datos del cliente</h3>
            <div>
                Nombre:
            </div>
            <div>
                Apellido:
            </div>
            <div>
                Teléfono:
            </div>
            <div>
                Email:
            </div>

        </div>

        <div class="footer">
            Gracias por tu compra!
        </div>

    </div>

</body>
</html>
