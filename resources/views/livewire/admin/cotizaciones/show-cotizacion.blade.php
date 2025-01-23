<div>
    <div>
        <x-validation-errors class="mb-4" />
        <section class="card">


            <header class="border-b px-6 py-2 border-gray-200">
                <h1>
                    <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Completar cotización</span>
                </h1>
            </header>

            <div class="px-6 py-4">
                <form wire:submit.prevent="">


                    <h1 class="text-xl font-bold mb-4">Cotización #{{ $cotizacion->id }}</h1>
                    <p class="mb-4"><strong>Proveedor:</strong> {{ $cotizacion->proveedor->name ?? 'N/A' }}</p>
                    <p class="mb-4"><strong>Fecha de creación:</strong> {{ $cotizacion->created_at->format('d/m/Y') }}</p>

                    <table class="table-auto w-full border border-gray-200">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-2 border">Variante</th>
                                <th class="px-4 py-2 border">Cantidad Solicitada</th>
                                <th class="px-4 py-2 border">Precio</th>
                                <th class="px-4 py-2 border">Cantidad Ofrecida</th>
                                <th class="px-4 py-2 border">Tiempo de Entrega</th>
                                <th class="px-4 py-2 border">Plazo Respuesta</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cotizacion->detalleCotizaciones as $detalle)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $detalle->variant->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-2 border">{{ $detalle->cantidad_solicitada }}</td>
                                    <td class="px-4 py-2 border">{{ $detalle->precio ? '$' . number_format($detalle->precio, 2) : 'Pendiente' }}</td>
                                    <td class="px-4 py-2 border">{{ $detalle->cantidad ?? 'Pendiente' }}</td>
                                    <td class="px-4 py-2 border">{{ $detalle->tiempo_entrega ?? 'Pendiente' }}</td>
                                    <td class="px-4 py-2 border">{{ $detalle->plazo_resp ? \Carbon\Carbon::parse($detalle->plazo_resp)->format('d/m/Y') : 'N/A' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                    {{-- Boton para enviar cotizacion --}}
                    <div class="flex justify-end mt-4">
                        <x-button>
                            Enviar cotización
                        </x-button>
                    </div>

                </form>
            </div>

        </section>
    </div>

</div>
