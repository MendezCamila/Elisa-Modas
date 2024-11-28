<x-app-layout>
    <x-container class="px-4 my-4">
        <div class="bg-white rounded-lg shadow overflow-hidden max-w-4xl mx-auto p-4">
            <h1 class="text-2xl font-semibold text-gray-700">¡Gracias por tu compra!</h1>
            <p class="text-gray-600">Tu pago ha sido procesado exitosamente.</p>
            {{--  <p class="text-gray-600">Tu número de orden es: <strong>{{ $order->id }}</strong></p>--}}
            <p>ID de pago: {{ $payment->id }} </p>
            <p>Estado: {{ $payment->status }}</p>
            <p class="text-gray-600">Recibirás un correo con los detalles de tu compra.</p>
            <a href="{{ route('welcome.index') }}"
                class="btn btn-primary mt-4">Volver al inicio</a>
        </div>
    </x-container>
</x-app-layout>
