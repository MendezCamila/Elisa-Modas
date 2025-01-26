<div>
    <x-validation-errors class="mb-4" />
    <section class="card shadow-lg rounded-lg overflow-hidden">
        {{-- Encabezado --}}
        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Cotización</span>
            </h1>
        </header>

        {{-- Contenido --}}
        <div class="px-6 py-6 bg-white">
            {{-- Título de la cotización --}}
            <h1 class="text-xl font-bold mb-6 text-gray-800">Cotización #{{ $cotizacion->id }}</h1>

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

            {{-- Proveedor --}}
            <div class="mb-6">
                <x-label value="Proveedor" class="font-medium text-gray-700 mb-2" />
                <p class="text-gray-800">
                    {{ $cotizacion->proveedor->name ?? 'Proveedor no disponible' }} {{ $cotizacion->proveedor->last_name ?? 'N/A' }}
                </p>
            </div>

            {{-- Fecha límite de respuesta --}}
            <div class="mb-6">
                <x-label value="Fecha límite de respuesta" class="font-medium text-gray-700 mb-2" />
                <p class="text-gray-800">
                    {{ $cotizacion->detalleCotizaciones->first()->plazo_resp ? \Carbon\Carbon::parse($cotizacion->detalleCotizaciones->first()->plazo_resp)->format('d/m/Y') : 'N/A' }}
                </p>
            </div>

            {{-- Botón para volver atrás --}}
            <div class="mt-6">
                <button onclick="window.history.back()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Volver Atrás
                </button>
            </div>
        </div>
    </section>
</div>



