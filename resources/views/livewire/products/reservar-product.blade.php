<div>
    <x-container>
        <div class="card shadow-lg rounded-lg overflow-hidden">
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Lado imagen --}}
                <div class="col-span-1">
                    <figure>
                        <img src="{{ $this->currentImage }}"
                             class="w-full aspect-[1/1] object-cover object-center"
                             alt="{{ $product->name }}">
                    </figure>
                </div>

                {{-- Lado información --}}
                <div class="col-span-1 p-6 relative">
                    {{-- Badge de Pre-Venta (lindo y llamativo) --}}
                    <div class="absolute top-0 right-0 bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs uppercase font-bold px-3 py-1 rounded-bl-lg shadow-lg">
                        ¡Pre-Venta!
                    </div>

                    <h1 class="text-2xl font-bold text-gray-700 mb-4">
                        {{ $product->name }}
                    </h1>

                    <div class="flex justify-between items-center mb-4">
                        {{-- Precio con descuento y precio original tachado --}}
                        <p class="text-2xl">
                            <span class="text-gray-500">Precio: </span>
                            <span class="text-red-500 font-bold">
                                ${{ number_format($this->discountedPrice, 2) }}
                            </span>
                            <span class="text-gray-500 line-through text-base ml-2">
                                ${{ number_format($product->price, 2) }}
                            </span>
                            <span class="text-gray-500 ml-1">pesos</span>
                        </p>

                        {{-- Stock disponible (usando el pool de la pre-venta) --}}
                        <p class="text-sm text-gray-600">
                            <span class="font-bold">Stock disponible:</span> {{ $this->currentStock }}
                        </p>
                    </div>

                    {{-- Controles para cantidad --}}
                    <div x-data="{ qty: @entangle('qty'), stock: @entangle('currentStock') }" class="flex space-x-6 items-center mb-6">
                        <button @click="qty > 1 ? qty-- : qty" class="btn btn-gray" :disabled="qty == 1">-</button>
                        <span x-text="qty" class="inline-block w-8 text-center"></span>
                        <button @click="qty++" :disabled="qty >= stock" class="btn btn-gray">+</button>
                    </div>

                    {{-- Mostrar solo las features correspondientes a la variante en pre-venta --}}
                    @php
                        // Agrupamos las features de la variante por su opción
                        $variantFeatures = $variant->features->groupBy('option_id');
                    @endphp

                    <div class="flex flex-wrap mb-6">
                        @foreach ($variantFeatures as $optionId => $features)
                            @php
                                // Buscamos el nombre de la opción en los options del producto
                                $option = $product->options->firstWhere('id', $optionId);
                            @endphp
                            @if($option)
                                <div class="mr-4 mb-4">
                                    <p class="font-semibold text-lg mb-2">{{ $option->name }}</p>
                                    <ul class="flex items-center space-x-4">
                                        @foreach ($features as $feature)
                                            <li>
                                                @if($option->type == 1)
                                                    {{-- Botón de tipo texto --}}
                                                    <div class="w-20 h-8 flex items-center justify-center font-semibold uppercase text-sm rounded-lg border border-gray-200 bg-pink-500 text-white">
                                                        {{ $feature->value }}
                                                    </div>
                                                @elseif($option->type == 2)
                                                    {{-- Botón de tipo color --}}
                                                    <div class="p-0.5 border-2 rounded-lg flex items-center -mt-1.5 border-pink-500">
                                                        <div class="w-20 h-8 rounded-lg border border-gray-200" style="background-color: {{ $feature->value }};"></div>
                                                    </div>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @endforeach
                    </div>

                    {{-- Descripción del producto --}}
                    <div class="text-gray-700 mb-6">
                        {{ $product->descripcion }}
                    </div>

                    {{-- Botón para reservar --}}
                    <button class="btn bg-gradient-to-r from-red-500 to-orange-500 w-full py-3 text-white font-bold rounded-lg hover:scale-105 transition"
                            wire:click="reservar" wire:loading.attr="disabled">
                        Reservar
                    </button>
                </div>
            </div>
        </div>
    </x-container>
</div>
