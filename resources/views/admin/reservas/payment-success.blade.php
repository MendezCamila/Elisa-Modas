<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserva Confirmada - Elisa Modas</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 my-4">
        <div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-semibold text-green-600">¡Reserva Confirmada!</h1>
                    <p class="text-gray-700">Tu pago ha sido procesado con éxito y tu reserva está asegurada.</p>
                    <p class="text-gray-600">ID de pago: <span class="font-medium">{{ $payment->id }}</span></p>
                    <p class="text-gray-600">Estado: <span class="font-medium">{{ $payment->status }}</span></p>
                </div>
                {{--
                <div>
                    <a href="{{ route('reservas.descargarComprobante', $reserva->id) }}" class="flex items-center bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                        <img class="h-6 mr-2" src="/img/iconos/pdf.png" alt="PDF Icon">
                        Descargar comprobante
                    </a>
                </div>
                --}}
            </div>

            <div class="bg-gray-100 p-4 rounded-lg mb-6">
                <h2 class="text-lg font-semibold text-gray-800">Detalles de la Reserva</h2>
                <p class="text-gray-600"><strong>Producto:</strong> {{ $reserva->preVenta->variant->product->name }}</p>
                <p class="text-gray-600"><strong>Cantidad:</strong> {{ $reserva->cantidad }}</p>
                <p class="text-gray-600">
                    <strong>Precio unitario:</strong> ${{ number_format($reserva->preVenta->variant->product->price, 2) }}
                </p>
                <p class="text-gray-600">
                    <strong>Descuento aplicado:</strong> {{ $reserva->preVenta->descuento }}%
                </p>
                <p class="text-gray-600">
                    <strong>Total a pagar:</strong> ${{ number_format($reserva->cantidad * $reserva->preVenta->variant->product->price * (1 - $reserva->preVenta->descuento / 100), 2) }}
                </p>
                <p class="text-gray-600"><strong>Estado de la reserva:</strong> {{ $reserva->estado }}</p>
            </div>


        </div>
    </div>
</body>
</html>
