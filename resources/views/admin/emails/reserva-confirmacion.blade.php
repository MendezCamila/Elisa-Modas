<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Reserva</title>
</head>
<body>
    <h1>Confirmación de Reserva</h1>
    <p>Hola {{ $reserva->user->name }},</p>
    <p>Gracias por reservar el producto {{ $reserva->preventa->variant->product->name }}.</p>
    <p>Detalles de la reserva:</p>
    <ul>
        <li>Producto: {{ $reserva->preventa->variant->product->name }}</li>
        <li>Cantidad: {{ $reserva->cantidad }}</li>
        <li>Precio: ${{ number_format($reserva->preventa->variant->product->price * (1 - $reserva->preventa->descuento / 100), 2) }}</li>
        <li>Estado: {{ $reserva->estado }}</li>
    </ul>
    <p>Te notificaremos cuando el producto esté disponible.</p>
    <p>Gracias,</p>
    <p>El equipo de Elisa Modas</p>
</body>
</html>
