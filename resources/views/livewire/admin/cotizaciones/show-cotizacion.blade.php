<div>
    <x-validation-errors class="mb-4" />
    <section class="card">
        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Completar cotización</span>
            </h1>
        </header>

        <div class="px-6 py-4">
            <form wire:submit.prevent="guardarCotizacion">
                <h1 class="text-xl font-bold mb-4">Cotización #{{ $cotizacion->id }}</h1>
                <p class="mb-4">
                <div class="mb-4">
                    @if ($proveedor)
                        <h2>Proveedor: {{ $proveedor->name }} {{ $proveedor->last_name }}</h2>
                    @else
                        <h2>No proveedor asignado</h2>
                    @endif
                </div>

                <p class="mb-4"><strong>Fecha de creación:</strong> {{ $cotizacion->created_at->format('d/m/Y') }}</p>
                <p class="mb-4"><strong>Plazo de respuesta:</strong>
                    {{ $cotizacion->detalleCotizaciones->first()->plazo_resp ? \Carbon\Carbon::parse($cotizacion->detalleCotizaciones->first()->plazo_resp)->format('d/m/Y') : 'N/A' }}
                </p>

                <table class="table-auto w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Variante</th>
                            <th class="px-4 py-2 border">Cantidad Solicitada</th>
                            <th class="px-4 py-2 border">Precio</th>
                            <th class="px-4 py-2 border">Cantidad Ofrecida</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cotizacion->detalleCotizaciones as $detalle)
                            <tr>
                                <td class="px-4 py-2 border">
                                    {{ $detalle->variant->product->name ?? 'N/A' }}
                                    @if ($detalle->variant->features->isNotEmpty())
                                        ({{ implode(', ', $detalle->variant->features->pluck('description')->toArray()) }})
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">{{ $detalle->cantidad_solicitada }}</td>
                                <td class="px-4 py-2 border">
                                    <input type="text"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                                        wire:model.defer="detalleCotizaciones.{{ $detalle->id }}.precio"
                                        placeholder="Precio por unidad"
                                        @if (!empty($detalleCotizaciones[$detalle->id]['no_disponible'])) disabled @endif />
                                </td>

                                <td class="px-4 py-2 border">
                                    <input type="number"
                                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                                        wire:model.defer="detalleCotizaciones.{{ $detalle->id }}.cantidad"
                                        placeholder="Cantidad ofrecida"
                                        @if (!empty($detalleCotizaciones[$detalle->id]['no_disponible'])) disabled @endif />
                                </td>
                                
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    <label for="tiempo_entrega" class="block font-medium text-sm text-gray-700">Tiempo de entrega
                        (días hábiles):</label>
                    <input type="number" id="tiempo_entrega" wire:model.defer="tiempo_entrega"
                        class="w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-opacity-50"
                        placeholder="Ingrese el tiempo de entrega en días" />
                </div>

                {{-- Botón para enviar cotización --}}
                <div class="flex justify-end mt-4">
                    <x-button>
                        Enviar cotización
                    </x-button>
                </div>
            </form>
        </div>
    </section
