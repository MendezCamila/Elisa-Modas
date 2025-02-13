<div>
    <x-container>
        <div class="card">
            <div class="grid md:grid-cols-2 gap-6">

                {{-- Lado producto --}}
                <div class="col-span-1">

                    <figure>
                        <img src="{{ $this->currentImage }}" class="aspect-[1/1] w-full object-cover object-center"
                            alt="">
                    </figure>
                </div>


                {{-- Lado informacion del producto --}}
                <div class="col-span-1">
                    <div>

                        

                        <h1 class="text-xl text-gray-700 mb-2">
                            {{ $product->name }}
                        </h1>

                        <div class="flex justify-between items-center">
                            {{-- precio --}}
                            <p class="mb-4 text-2xl">
                                <span class="text-gray-500">Precio:</span>
                                <span class="text-gray-700 font-bold">{{ $product->price }}</span>
                                <span class="text-gray-500">pesos</span>
                            </p>

                            {{-- Stock dinamico --}}
                            <p class="text-sm mb-4 text-gray-600">
                                <span class="font-bold">Stock disponible:</span> {{ $this->currentStock }}
                            </p>
                        </div>



                        <div x-data="{
                            qty: @entangle('qty'),
                            stock: @entangle('stock')
                            }"

                            class="flex space-x-6 items-center mb-6">

                            <button @click="qty > 1 ? qty-- : qty" class="btn btn-gray" x-bind:disabled="qty == 1">
                                -
                            </button>
                            <span x-text="qty" class="inline-block w-2 text-center"></span>
                            <button @click="qty++"
                                :disabled="qty >= stock"
                                class="btn btn-gray">
                                +
                            </button>
                        </div>



                        {{-- Variantes a seleccionar --}}
                        <div class="flex flex-wrap">
                            @foreach ($product->options as $option)
                                <div class="mr-4 mb-4">
                                    <p class="font-semibold text-lg mb-2">
                                        {{ $option->name }}
                                    </p>

                                    <ul class="flex items-center space-x-4">
                                        @foreach ($option->pivot->features as $feature)
                                            <li>

                                                @switch($option->type)
                                                    @case(1)
                                                        {{-- es de tipo texto --}}

                                                        <button
                                                            class="w-20 h-8 font-semibold uppercase text-sm rounded-lg border-gray-200 text-gray-700 {{ $selectedFeatures[$option->id] == $feature['id'] ? ' bg-pink-500 text-white' : ' bg-gray-200' }} "
                                                            wire:click="$set('selectedFeatures.{{ $option->id }}', {{ $feature['id'] }})">

                                                            {{ $feature['value'] }}
                                                        </button>
                                                    @break

                                                    @case(2)
                                                        {{-- es de tipo color --}}

                                                        <div
                                                            class="p-0.5 border-2 rounded-lg flex items-center -mt-1.5 {{ $selectedFeatures[$option->id] == $feature['id'] ? ' border-pink-500' : 'border-transparent' }}">
                                                            <button class="w-20 h-8 rounded-lg border border-gray-200 "
                                                                style="background-color: {{ $feature['value'] }}"
                                                                wire:click="$set('selectedFeatures.{{ $option->id }}', {{ $feature['id'] }})">
                                                            </button>
                                                        </div>
                                                    @break

                                                    @default
                                                @endswitch
                                            </li>
                                        @endforeach
                                    </ul>


                                </div>
                            @endforeach
                        </div>


                        <div class="text-sm mb-4">
                            {{ $product->descripcion }}
                        </div>


                        <button class="btn btn-pink w-full mb-6" wire:click="add_to_cart" wire:loading.attr="disabled">

                            Añadir al carrito
                        </button>

                    </div>
                </div>

            </div>

        </div>
    </x-container>
</div>
