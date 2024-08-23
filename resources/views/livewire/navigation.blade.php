<div>

    <header class="bg-pink-300">

            <x-container class="px-4 py-4">

                <div class="flex items-center space-x-8">

                    <button class="text-3xl">
                        <i class="fas fa-bars text-white"></i>
                    </button>

                    <h1 class="text-white">
                        <a href="/" class="inline-flex flex-col items-end">
                            <span class="text-3xl leading-6 font-semibold">
                                Elisa Modas
                            </span>

                            <span class="text-xs">
                                Tienda online
                            </span>
                        </a>
                    </h1>

                    {{-- input para la busqueda --}}
                    <div class="flex-1">
                        <x-input class="w-full" placeholder="Buscar producto"/>
                    </div>

                    <div class="space-x-8">

                        <button class="text-3xl">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </button>

                        <button class="text-3xl">
                            <i class="fas fa-user text-white"></i>
                        </button>

                    </div>

                </div>
            </x-container>

    </header>

</div>
