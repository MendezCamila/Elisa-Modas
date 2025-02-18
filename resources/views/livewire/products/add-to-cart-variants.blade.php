<div>
    <x-container>
        <div class="card">
            <div class="grid md:grid-cols-2 gap-6">
                {{-- Lado producto: Imagen --}}
                <div class="col-span-1">
                    <figure>
                        <img src="{{ $this->currentImage }}" class="aspect-[1/1] w-full object-cover object-center" alt="{{ $product->name }}">
                    </figure>
                </div>

                {{-- Lado información del producto --}}
                <div class="col-span-1">
                    <div>
                        <h1 class="text-xl text-gray-700 mb-2">{{ $product->name }}</h1>

                        <div class="flex justify-between items-center">
                            {{-- Precio --}}
                            <p class="mb-4 text-2xl">
                                <span class="text-gray-500">Precio:</span>
                                <span class="text-gray-700 font-bold">${{ number_format($product->price, 2) }}</span>
                                <span class="text-gray-500">pesos</span>
                            </p>

                            {{-- Stock dinámico (por ejemplo, calculado en el componente Livewire) --}}
                            <p class="text-sm mb-4 text-gray-600">
                                <span class="font-bold">Stock disponible:</span> {{ $this->currentStock }}
                            </p>
                        </div>

                        {{-- Controles para cantidad --}}
                        <div x-data="{ qty: @entangle('qty'), stock: @entangle('stock') }" class="flex space-x-6 items-center mb-6">
                            <button @click="qty > 1 ? qty-- : qty" class="btn btn-gray" :disabled="qty == 1">
                                -
                            </button>
                            <span x-text="qty" class="inline-block w-8 text-center"></span>
                            <button @click="qty++" :disabled="qty >= stock" class="btn btn-gray">
                                +
                            </button>
                        </div>

                        {{-- Mostrar variantes disponibles y sus opciones --}}
                        @php
                            // Obtenemos las variantes a mostrar usando el accesor displayVariants definido en el modelo Product
                            $displayVariants = $product->displayVariants;
                        @endphp

                        @if ($displayVariants->count() > 0)
                            <div class="mb-4">
                                <h2 class="text-lg font-bold text-gray-700 mb-2">Opciones:</h2>
                                {{-- Iteramos sobre las opciones del producto --}}
                                <div class="flex flex-wrap">
                                    @foreach ($product->options as $option)
                                        @php
                                            // Filtrar las features de este option que pertenecen a alguna variante visible
                                            $featuresToShow = collect($option->pivot->features)->filter(function($feature) use ($displayVariants) {
                                                foreach ($displayVariants as $variant) {
                                                    if ($variant->features->contains('id', $feature['id'])) {
                                                        return true;
                                                    }
                                                }
                                                return false;
                                            });
                                        @endphp
                                        @if ($featuresToShow->count())
                                            <div class="mr-4 mb-4">
                                                <p class="font-semibold text-lg mb-2">{{ $option->name }}</p>
                                                <ul class="flex items-center space-x-4">
                                                    @foreach ($featuresToShow as $feature)
                                                        <li>
                                                            @if ($option->type == 1)
                                                                {{-- Botón de tipo texto --}}
                                                                <button class="w-20 h-8 font-semibold uppercase text-sm rounded-lg border border-gray-200 text-gray-700 {{ (isset($selectedFeatures[$option->id]) && $selectedFeatures[$option->id] == $feature['id']) ? 'bg-pink-500 text-white' : 'bg-gray-200' }}"
                                                                        wire:click="$set('selectedFeatures.{{ $option->id }}', {{ $feature['id'] }})">
                                                                    {{ $feature['value'] }}
                                                                </button>
                                                            @elseif ($option->type == 2)
                                                                {{-- Botón de tipo color --}}
                                                                <div class="p-0.5 border-2 rounded-lg flex items-center -mt-1.5 {{ (isset($selectedFeatures[$option->id]) && $selectedFeatures[$option->id] == $feature['id']) ? 'border-pink-500' : 'border-transparent' }}">
                                                                    <button class="w-20 h-8 rounded-lg border border-gray-200"
                                                                            style="background-color: {{ $feature['value'] }}"
                                                                            wire:click="$set('selectedFeatures.{{ $option->id }}', {{ $feature['id'] }})">
                                                                    </button>
                                                                </div>
                                                            @endif
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Descripción del producto --}}
                        <div class="text-sm mb-4">{{ $product->descripcion }}</div>

                        {{-- Botón para agregar al carrito --}}
                        <button class="btn btn-pink w-full mb-6" wire:click="add_to_cart" wire:loading.attr="disabled">
                            Añadir al carrito
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </x-container>
</div>
