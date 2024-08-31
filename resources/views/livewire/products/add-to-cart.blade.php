<x-container>

    <div class="card">
        <div class="grid md:grid-cols-2 gap-6">

            {{-- Lado producto --}}
            <div class="col-span-1">

                <figure class="mb-2">
                    <img src="{{ $product->image }}" class="aspect-[16/9] w-full object-cover object-center" alt="">
                </figure>

                <div class="text-sm">
                    {{ $product->descripcion }}
                </div>

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

                <button class="btn btn-pink w-full mb-6"
                    wire:click="add_to_cart"
                    wire:loading.attr="disabled">

                    Añadir al carrito
                </button>

                <div class="text-gray-600 flex items-center space-x-4">
                    <i class="fa-solid fa-truck-fast text-2xl"></i>
                    <p>
                        Envio a domicilio
                    </p>
                </div>



            </div>

        </div>
    </div>


</x-container>
