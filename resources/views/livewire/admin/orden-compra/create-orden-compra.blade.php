<div class="card">
    <form wire:submit.prevent="submit">
        {{-- Información del proveedor --}}
        <div class="mb-6">
            <x-label value="Proveedor" class="font-medium text-gray-700 mb-2" />
            <p class="text-gray-800">
                {{ $cotizacion->proveedor->name ?? 'Proveedor no disponible' }} {{ $cotizacion->proveedor->last_name ?? 'N/A' }}
            </p>
        </div>


        {{-- Variantes --}}
        <div class="mb-6">
            <x-label value="Variantes" class="font-medium text-gray-700 mb-2" />
            <table class="table-auto w-full border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200 text-gray-600">
                        <th class="px-4 py-2 border text-left">Producto</th>
                        <th class="px-4 py-2 border text-center">Cantidad Solicitada</th>
                        <th class="px-4 py-2 border text-left">Características</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cotizacion->detalleCotizaciones as $detalle)
                        <tr class="hover:bg-gray-100">
                            <td class="px-4 py-2 border text-left">{{ $detalle->variant->product->name ?? 'N/A' }}</td>
                            <td class="px-4 py-2 border text-center">
                                {{ $detalle->cantidad_solicitada }} unidades
                            </td>
                            <td class="px-4 py-2 border text-left">
                                @if ($detalle->variant->features->isNotEmpty())
                                    {{ implode(', ', $detalle->variant->features->pluck('description')->toArray()) }}
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end">
            <x-button>
                Enviar Orden de Compra
            </x-button>
        </div>
    </form>
</div>
