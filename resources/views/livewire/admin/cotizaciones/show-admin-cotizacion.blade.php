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
                            {{ $detalle->variant->name ?? 'N/A' }}
                            - Producto: {{ $detalle->variant->product->name ?? 'N/A' }} <!-- Aquí agregamos el nombre del producto -->
                            - Cantidad: {{ $detalle->cantidad_solicitada }}
                        </li>
                    @endforeach
                </ul>
            </div>--}}

            {{-- Mostrar variantes --}}
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

