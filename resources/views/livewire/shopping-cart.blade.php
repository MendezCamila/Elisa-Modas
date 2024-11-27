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
                        <li class="lg:flex {{ $item->qty > $item->options['stock'] ? 'text-red-600' : ''  }}">
                            <img class="w-full lg:w-36 aspect-[4/3] object-cover object-center mr-2"
                                src="{{ $item->options->image }}" alt="">

                            <div class="w-80">

                                @if ($item->qty > $item->options['stock'])
                                    <p class="font-semibold">
                                        Stock insuficiente
                                    </p>
                                @endif

                                <p class="text-sm truncate">
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
                                <span class="text-gray-500">Precio: $</span>
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
                                    wire:click="incrementar('{{ $item->rowId }}')"
                                    @disabled($item->qty >= $item->options['stock'] )>
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
                        $ {{ $this->subtotal }}
                    </p>
                </div>

                <div id="wallet_container"></div>

            </div>
        </div>

    </div>



    <script src="https://sdk.mercadopago.com/js/v2"></script>

    <script>

        // Inicializa el SDK de MercadoPago con tu clave pública
        const mp = new MercadoPago('APP_USR-0aa68677-d975-402d-ba8a-5032d9064624'); // Reemplaza con tu clave pública de Mercado Pago
        const bricksBuilder = mp.bricks();

        // Obtén el ID de la preferencia generada desde el backend
        const preferenceId = "{{ $preferenceId }}"; // Usa el ID de la preferencia aquí

        // Crea el botón de pago en el contenedor especificado
        mp.bricks().create("wallet", "wallet_container", {
            initialization: {
                preferenceId: preferenceId, // Usa el ID de la preferencia aquí
            },
            customization: {
                texts: {
                    valueProp: 'smart_option', // Personaliza el texto que aparece en el botón si lo deseas
                },
            },
        });
    </script>

</div>


