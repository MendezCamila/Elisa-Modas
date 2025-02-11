<!-- resources/views/emails/product_available.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Producto Disponible</title>
</head>
<body>
    <p>Hola {{ $reservation->user->name }},</p>

    <p>El producto que reservaste ya llegó a nuestro inventario.</p>

    <p>
        <strong>Para pagar en línea:</strong><br>
        Haz clic en el siguiente enlace para completar tu pago a través de Mercado Pago:<br>
        <a href="{{--  {{ route('reservation.onlinePayment', $reservation->id) }}--}}">Pagar en línea</a>
    </p>

    <p>
        <strong>Si prefieres pagar en el local:</strong><br>
        Preséntate en nuestra tienda y menciona tu reserva. Tu reserva se mantendrá pendiente hasta que el administrador la marque como pagada.
    </p>

    <p>Gracias por confiar en nosotros.</p>
</body>
</html>
