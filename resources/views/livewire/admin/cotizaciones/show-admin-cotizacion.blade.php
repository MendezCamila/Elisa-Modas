<div>
    <x-validation-errors class="mb-4" />
    <section class="card">
        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Ver Cotización</span>
            </h1>
        </header>

        <div class="px-6 py-4">
            <div class="mb-4">
                <x-label value="Nombre" />
                <p>{{ $cotizacion->nombre }}</p>
            </div>


            {{-- Mostrar subcategorías
            <div class="mb-4">
                <x-label value="Subcategorías" />
                <ul>
                    @foreach ($cotizacion->subcategories as $subcategory)
                        <li>{{ $subcategory->name }} ({{ $subcategory->category->name }} - {{ $subcategory->category->family->name }})</li>
                    @endforeach
                </ul>
            </div> --}}

            {{-- Mostrar variantes --}}
            <div class="mb-4">
                <x-label value="Variantes" />
                <ul>
                    @foreach ($cotizacion->detalleCotizaciones as $detalle)
                        <li>
                            {{ $detalle->variant->name ?? 'N/A' }}
                            - Cantidad: {{ $detalle->cantidad_solicitada }}
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Mostrar proveedores
            <div class="mb-4">
                <x-label value="Proveedores" />
                <ul>
                    @foreach ($cotizacion->suppliers as $supplier)
                        <li>{{ $supplier->name }} {{ $supplier->last_name }}</li>
                    @endforeach
                </ul>
            </div> --}}

            {{ $cotizacion->proveedor->name ?? 'Proveedor no disponible' }}

            {{-- Mostrar fecha límite --}}
            <div class="mb-4">
                <x-label value="Fecha límite de respuesta" />
                <p>{{ $cotizacion->plazo_resp ? $cotizacion->plazo_resp->format('d/m/Y') : 'N/A' }}</p>
            </div>
        </div>
    </section>
</div>
