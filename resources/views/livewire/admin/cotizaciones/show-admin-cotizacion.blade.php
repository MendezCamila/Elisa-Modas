<div>
    <x-validation-errors class="mb-4" />
    <section class="card">
        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Ver Cotización</span>
            </h1>
        </header>

        <div class="px-6 py-4">



            {{-- Mostrar variantes
            <div class="mb-4">
                <x-label value="Variantes" />
                <ul>
                    @foreach ($cotizacion->detalleCotizaciones as $detalle)
                        <li>
                            - Producto: {{ $detalle->variant->product->name ?? 'N/A' }}
                            - Cantidad: {{ $detalle->cantidad_solicitada }}
                            @if ($detalle->variant->features->isNotEmpty())
                                - Características: {{ implode(', ', $detalle->variant->features->pluck('description')->toArray()) }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>--}}

            <div class="mb-4">
                <x-label value="Variantes" />
                <table class="table-auto w-full border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-4 py-2 border">Producto</th>
                            <th class="px-4 py-2 border">Cantidad Solicitada</th>
                            <th class="px-4 py-2 border">Características</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cotizacion->detalleCotizaciones as $detalle)
                            <tr>
                                <td class="px-4 py-2 border">{{ $detalle->variant->product->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2 border">{{ $detalle->cantidad_solicitada }}</td>
                                <td class="px-4 py-2 border">
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

            {{-- Mostrar el proveedor --}}
            <div class="mb-4">
                <x-label value="Proveedor" />
                <p>{{ $cotizacion->proveedor->name ?? 'Proveedor no disponible' }} {{ $cotizacion->proveedor->last_name ?? 'N/A' }}</p> <!-- Mostrar nombre completo del proveedor -->
            </div>

            {{-- Mostrar fecha límite de respuesta --}}
            <div class="mb-4">
                <x-label value="Fecha límite de respuesta" />
                <p>{{ $cotizacion->detalleCotizaciones->first()->plazo_resp ? \Carbon\Carbon::parse($cotizacion->detalleCotizaciones->first()->plazo_resp)->format('d/m/Y') : 'N/A' }}</p> <!-- Acceder al plazo_resp desde detalleCotizacion -->
            </div>
        </div>
    </section>
</div>

