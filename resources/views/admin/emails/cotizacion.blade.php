<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>holis</title>
</head>
<body>
    <p>Estimado proveedor,</p>

<p>Se le ha enviado una nueva cotización. Por favor, haga clic en el siguiente enlace para ver y responder a la cotización:</p>

<p><a href="{{ url('/cotizacion/' . $cotizacion->id) }}">Ver Cotización</a></p>

<p>Gracias,</p>
<p>El equipo de Elisa Modas</p>

</body>
</html>
