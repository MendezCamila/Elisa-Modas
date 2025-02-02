<div>
    <x-validation-errors class="mb-4" />
    <section class="card shadow-lg rounded-lg overflow-hidden">
        {{-- Encabezado --}}
        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Respuesta de Cotización</span>
            </h1>
        </header>

        {{-- Contenido --}}
        <div class="px-6 py-4">
            {{-- Título de la cotización --}}
            <h1 class="text-xl font-bold mb-6 text-gray-800">Cotización #{{ $cotizacion->id }}</h1>

            {{-- Información del proveedor --}}
            <div class="mb-6">
                <p class="text-gray-800"><strong>Proveedor:</strong>
                    @if($proveedor)
                        {{ $proveedor->name }} {{ $proveedor->last_name }}
                    @else
                        No proveedor asignado
                    @endif
                </p>
            </div>

            {{-- Fecha de creación y plazo de respuesta --}}
            <div class="mb-6">
                <p class="text-gray-800"><strong>Fecha de creación:</strong> {{ $cotizacion->created_at->format('d/m/Y') }}</p>
                <p class="text-gray-800"><strong>Plazo de respuesta:</strong>
                    {{ $cotizacion->detalleCotizaciones->first()->plazo_resp ? \Carbon\Carbon::parse($cotizacion->detalleCotizaciones->first()->plazo_resp)->format('d/m/Y') : 'N/A' }}
                </p>
            </div>

            {{-- Tabla de variantes --}}
            <div class="mb-6">
                <x-label value="Detalles de las variantes" class="font-medium text-gray-700 mb-2" />
                <table class="table-auto w-full border border-gray-300 text-sm">
                    <thead>
                        <tr class="bg-gray-200 text-gray-600">
                            <th class="px-4 py-2 border text-left">Variante</th>
                            <th class="px-4 py-2 border text-center">Cantidad Solicitada</th>
                            <th class="px-4 py-2 border text-right">Precio</th>
                            <th class="px-4 py-2 border text-center">Cantidad Ofrecida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cotizacion->detalleCotizaciones as $detalle)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2 border text-left">
                                    {{ $detalle->variant->product->name ?? 'N/A' }}
                                    @if ($detalle->variant->features->isNotEmpty())
                                        ({{ implode(', ', $detalle->variant->features->pluck('description')->toArray()) }})
                                    @endif
                                </td>
                                <td class="px-4 py-2 border text-center">
                                    {{ $detalle->cantidad_solicitada }} unidades
                                </td>

                                {{-- Verificación para mostrar si el producto no está disponible --}}
                                @if (is_null($detalle->cantidad) && is_null($detalle->precio))
                                    <td colspan="2" class="px-4 py-2 border text-center text-red-500 font-semibold">
                                        Producto no disponible
                                    </td>
                                @else
                                    <td class="px-4 py-2 border text-right">
                                        {{ $detalle->precio ? '$' . number_format($detalle->precio, 2) : 'N/A' }}
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        {{ $detalle->cantidad ?? 'N/A' }} unidades
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Tiempo de entrega --}}
            <div class="mb-6">
                <label for="tiempo_entrega" class="block font-medium text-sm text-gray-700">Tiempo de entrega (días):</label>
                <p class="text-gray-800">{{ $cotizacion->detalleCotizaciones->first()->tiempo_entrega ?? 'N/A' }}</p>
            </div>

            {{-- Botones --}}
            <div class="mt-6 flex justify-between">
                {{-- Botón para volver atrás --}}
                <button onclick="window.history.back()" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Volver Atrás
                </button>
                {{-- Botón para crear orden de compra --}}
                <a href="{{ route('admin.orden-compras.create', ['cotizacion_id' => $cotizacion->id]) }}"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Crear Orden de Compra
                </a>
            </div>
        </div>
    </section>
</div>





