<x-app-layout>
    <div>
        <x-container>
            <div class="card">
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
