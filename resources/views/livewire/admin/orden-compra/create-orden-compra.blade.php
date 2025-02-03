<div class="card">
    <x-validation-errors class="mb-4" />
    @if (session()->has('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <strong class="font-bold">¡Error!</strong>
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif
    <form wire:submit.prevent="submit">

        {{-- Información del proveedor --}}
        <div class="mb-6">
            <x-label value="Proveedor" class="font-medium text-gray-700 mb-2" />
            <p class="text-gray-800">
                {{ $proveedor->name ?? 'Proveedor no disponible' }} {{ $proveedor->last_name ?? 'N/A' }}
            </p>
        </div>

        {{-- Variantes --}}
        <div class="mb-6">
            <x-label value="Variantes" class="font-medium text-gray-700 mb-2" />

            @if (empty($detalles))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">¡No hay productos seleccionados!</strong>
                    <span class="block sm:inline">Debes agregar al menos un producto para enviar la orden de compra.</span>
                </div>
            @endif

            <table class="table-auto w-full border border-gray-300 text-sm">
                <thead>
                    <tr class="bg-gray-200 text-gray-600">
                        <th class="px-4 py-2 border text-left">Variante</th>
                        <th class="px-4 py-2 border text-center">Cantidad Ofrecida</th>
                        <th class="px-4 py-2 border text-right">Precio</th>
                        <th class="px-4 py-2 border text-center">Cantidad Solicitada</th>
                        <th class="px-4 py-2 border text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($detalles as $index => $detalle)
                        @if ($cotizacion->detalleCotizaciones[$index]->disponible == 1)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border text-left">
                                    {{ $cotizacion->detalleCotizaciones[$index]->variant->product->name ?? 'N/A' }}
                                    @if ($cotizacion->detalleCotizaciones[$index]->variant->features->isNotEmpty())
                                        ({{ implode(', ', $cotizacion->detalleCotizaciones[$index]->variant->features->pluck('description')->toArray()) }})
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    {{ $detalle['cantidad_ofrecida'] ?? 'N/A' }} unidades
                                </td>
                                <td class="px-4 py-2 border text-right">
                                    {{ $detalle['precio'] ? '$' . number_format($detalle['precio'], 2) : 'N/A' }}
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <input type="number" wire:model="detalles.{{ $index }}.cantidad_solicitada"
                                        class="form-input w-full" />
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    <button type="button" wire:click="removeProducto({{ $index }})"
                                        class="px-3 py-1 text-white bg-red-500 rounded hover:bg-red-600 focus:outline-none"
                                        @if (count($detalles) <= 1) disabled @endif>
                                        X
                                    </button>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-between">
            {{-- Botón para volver atrás --}}
            <button onclick="window.history.back()"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Volver Atrás
            </button>

            <x-button>
                Enviar Orden de Compra
            </x-button>
        </div>
    </form>
</div>
