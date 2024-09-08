<div>


    <div class="grid  grid-cols-1 lg:grid-cols-7 gap-6">

        {{-- parte izquiera --}}
        <div class=" lg:col-span-5">
            <div class="flex justify-between mb-2">
                <h1 class="text-lg">
                    Carrito de compras ({{ Cart::count() }} productos )
                </h1>

                <button class="font-semibold text-gray-700 hover:text-pink-400 underline hover:no-underline "
                    wire:click="destroy()">
                    Limpiar carrito
                </button>
            </div>

            <div class="card">
                <ul class="space-y-4">
                    @forelse (Cart::content() as $item)
                        <li class="lg:flex">
                            <img class="w-full lg:w-36 aspect-[16/9] object-cover object-center mr-2"
                                src="{{ $item->options->image }}" alt="">

                            <div class="w-80">
                                <p class="text-sm">
                                    <a href="{{ route('products.show', $item->id) }}">
                                        {{ $item->name }}
                                    </a>
                                </p>
                                <button
                                    class="bg-red-400 text-xs text-white font-semibold py-0.5 px-2.5 rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-opacity-75 transition duration-300"
                                        wire:click="quitar('{{ $item->rowId }}')">
                                    <i class="fa-solid fa-xmark">

                                    </i>
                                    Quitar
                                </button>
                            </div>

                            <div class="flex space-x-1">
                                <span class="text-gray-500">Precio:</span>
                                <p>
                                    {{ $item->price }}
                                </p>
                            </div>

                            <div class="ml-auto space-x-3">

                                <button class="btn btn-gray"
                                    wire:click="decrementar('{{ $item->rowId }}')">
                                    -
                                </button>

                                <span class="inline-block w-2 text-center">
                                    {{ $item->qty }}
                                </span>

                                <button class="btn btn-gray"
                                    wire:click="incrementar('{{ $item->rowId }}')">
                                    +
                                </button>
                            </div>



                        </li>

                    @empty
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative"
                            role="alert">
                            <strong class="font-bold">¡Carrito vacío!</strong>
                            <span class="block sm:inline">No hay productos en tu carrito de compras.</span>
                            <span class="absolute top-0 bottom-0 right-0 px-4 py-3">
                            </span>
                        </div>
                    @endforelse
                </ul>
            </div>
        </div>

        {{-- parte derecha --}}
        <div class="lg:col-span-2">
            <div class="card">

                <div class="flex justify-between font-semibold mb-2">
                    <p>
                        Total:
                    </p>
                    <p>
                        $ {{ Cart::subtotal() }}
                    </p>
                </div>

                <a href="" class="btn btn-pink block w-full text-center">
                    Continuar compra
                </a>

            </div>
        </div>

    </div>


</div>
