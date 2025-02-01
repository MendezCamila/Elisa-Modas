<x-app-layout>
    <div class="mt-6">

        <x-container>
            <div class="mb-4 flex justify-start">
                <button onclick="window.history.back()" class="text-blue-500 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
            </div>
            <div class="card p-6 bg-white shadow-md rounded-lg">
                <h1 class="text-2xl font-bold mb-4">Detalles de la compra</h1>

                <div class="mb-4">
                    <p><span class="font-bold">Fecha:</span> {{ $purchase->created_at->format('d/m/Y') }}</p>
                    <p><span class="font-bold">Total:</span> ${{ number_format($purchase->total, 2) }}</p>
                </div>

                {{-- Productos comprados --}}
                <h3 class="text-lg font-bold mb-2">Productos comprados</h3>

                <div class="grid grid-cols-1 gap-4">
                    @foreach($purchase->content as $item)
                        <div class="bg-white p-4 rounded-lg shadow-md flex items-center">
                            <img src="{{ $item['options']['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover rounded-lg mr-4">
                            <div>
                                <h4 class="font-bold">{{ $item['name'] }}</h4>
                                <p>Cantidad: {{ $item['qty'] }}</p>
                                <p>Precio: ${{ number_format($item['price'], 2) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </x-container>
    </div>

</x-app-layout>
