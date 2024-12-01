<x-app-layout>
    <x-container class="px-4 my-4">
        <div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto p-4">
            <div class="flex justify-between items-center mb-4">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-700">¡Gracias por tu compra!</h1>
                    <p class="text-gray-600">Tu pago ha sido procesado exitosamente.</p>
                    <p>ID de pago: {{ $payment->id }} </p>
                    <p>Estado: {{ $payment->status }}</p>
                </div>
                <div>
                    <a href="{{ route('ventas.descargarComprobante', $venta->id) }}" class="btn btn-secondary">
                        <img class="h-6 mr-2" src="/img/iconos/pdf.png" alt="PDF Icon"> Descargar comprobante
                    </a>
                </div>
            </div>


            <a href="{{ route('welcome.index') }}" class="btn btn-primary mt-4">
                Volver al inicio
            </a>



        </div>
    </x-container>
</x-app-layout>
