<x-container>

    <div class="card">
        <div class="grid md:grid-cols-2 gap-6">

            {{-- Lado producto --}}
            <div class="col-span-1">

                <figure>
                    <img src="{{ $this->variant->image }}" class="aspect-[1/1] w-full object-cover object-center" alt="">
                </figure>
            </div>

            {{-- Lado informacion del producto --}}
            <div class="col-span-1">
                <h1 class="text-xl text-gray-700 mb-2">
                    {{ $product->name }}
                </h1>

                {{-- Estrellas/puntuacion producto --}}
                <div class="flex items-center space-x-2 mb-4">
                    <ul class="flex space-x-1 text-sm">
                        <li>
                            <i class="fa-solid fa-star text-yellow-400"></i>
                        </li>
                        <li>
                            <i class="fa-solid fa-star text-yellow-400"></i>
                        </li>
                        <li>
                            <i class="fa-solid fa-star text-yellow-400"></i>
                        </li>
                        <li>
                            <i class="fa-solid fa-star text-yellow-400"></i>
                        </li>
                        <li>
                            <i class="fa-solid fa-star text-yellow-400"></i>
                        </li>
                    </ul>

                    <p class="text-sm text-gray-500">4.7 (45)</p>
                </div>

                <p class="mb-4 text-2xl">
                    <span class="text-gray-500">Precio:</span>
                    <span class="text-gray-700 font-bold">{{ $product->price }}</span>
                </p>


                <div x-data="{ qty: @entangle('qty') }" class="flex space-x-6 items-center mb-6">
                    <button @click="qty > 1 ? qty-- : qty" class="btn btn-gray" x-bind:disabled="qty == 1">
                        -
                    </button>

                    <span x-text="qty" class="inline-block w-2 text-center"></span>

                    <button @click="qty++" class="btn btn-gray">
                        +
                    </button>
                </div>

                {{-- Variantes a seleccionar --}}
                <div class="flex flex-wrap">
                    @foreach ($product->options as $option )

                        <div class="mr-4 mb-4">
                            <p class="font-semibold text-lg mb-2">
                                {{ $option->name }}
                            </p>

                            <ul class="flex items-center space-x-4">
                                @foreach ($option->pivot->features as $feature)
                                    <li>

                                        @switch($option->type)
                                            @case(1) {{-- es de tipo texto --}}

                                                <button class="w-20 h-8 font-semibold uppercase text-sm rounded-lg border-gray-200 text-gray-700 {{ $selectedFeatures[$option->id] == $feature['id'] ? ' bg-pink-500 text-white' : ' bg-gray-200'  }} "
                                                    wire:click="$set('selectedFeatures.{{ $option->id }}', {{ $feature['id'] }})">

                                                    {{ $feature['value'] }}
                                                </button>

                                                @break
                                            @case(2) {{-- es de tipo color --}}

                                                <div class="p-0.5 border-2 rounded-lg flex items-center -mt-1.5 {{ $selectedFeatures[$option->id] == $feature['id'] ? ' border-pink-500' : 'border-transparent'  }}">
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

                    @dump($selectedFeatures)


                </div>


                <div class="text-sm mb-4">
                    {{ $product->descripcion }}
                </div>


                <button class="btn btn-pink w-full mb-6"
                    wire:click="add_to_cart"
                    wire:loading.attr="disabled">

                    Añadir al carrito
                </button>



                {{--
                <div class="text-gray-600 flex items-center space-x-4">
                    <i class="fa-solid fa-truck-fast text-2xl"></i>
                    <p>
                        Envio a domicilio
                    </p>
                </div>
                --}}



            </div>

        </div>
    </div>


</x-container>
