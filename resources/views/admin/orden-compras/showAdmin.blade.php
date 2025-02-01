<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Orden de compras',
        'route' => route('admin.orden-compras.index'),
    ],
    [
        'name' => 'Detalles de la Orden de Compra',
    ],
]">
    <div class="card bg-white shadow-sm rounded-lg p-6">
        <div class="card-header mb-4 border-b pb-4">
            <h3 class="text-lg font-semibold text-gray-700">Detalles de la Orden de Compra #{{ $ordenCompra->id }}</h3>
        </div>
        <div class="card-body space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p class="text-sm text-gray-600"><strong>Proveedor:</strong> {{ $ordenCompra->proveedor->name }} {{ $ordenCompra->proveedor->last_name }}</p>
                <p class="text-sm text-gray-600"><strong>Estado:</strong> <span class="badge badge-{{ $ordenCompra->estado === 'activo' ? 'success' : 'danger' }}">{{ ucfirst($ordenCompra->estado) }}</span></p>
                <p class="text-sm text-gray-600"><strong>Fecha de Creación:</strong> {{ $ordenCompra->created_at->format('d/m/Y') }}</p>
                <p class="text-sm text-gray-600"><strong>Fecha de Actualización:</strong> {{ $ordenCompra->updated_at->format('d/m/Y') }}</p>
            </div>

            <h4 class="text-md font-semibold text-gray-700 mt-6">Detalles de la Orden de Compra</h4>
            <div class="overflow-x-auto">
                <table class="table-auto w-full border border-gray-200 rounded-lg text-left text-sm text-gray-700">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border-b">Producto</th>
                            <th class="px-4 py-2 border-b">Variante</th>
                            <th class="px-4 py-2 border-b">Cantidad</th>
                            <th class="px-4 py-2 border-b">Precio Unitario</th>
                            <th class="px-4 py-2 border-b">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ordenCompra->detalleOrdenCompras as $detalle)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 border-b">{{ $detalle->variant->product->name ?? 'Producto no disponible' }}</td>
                                <td class="px-4 py-2 border-b">{{ $detalle->variant->sku ?? 'Variante no disponible' }}</td>
                                <td class="px-4 py-2 border-b">{{ $detalle->cantidad }} unidades</td>
                                <td class="px-4 py-2 border-b">{{ number_format($detalle->precio_unitario, 2) }}</td>
                                <td class="px-4 py-2 border-b">{{ number_format($detalle->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Botón para volver atrás --}}
            <div class="mt-6">
                <button onclick="window.history.back()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Volver Atrás
                </button>
            </div>
        </div>
    </div>
</x-admin-layout>

