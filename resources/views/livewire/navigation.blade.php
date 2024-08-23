<div>

    <header class="bg-pink-500">

            <x-container class="px-4 py-4">

                <div class="flex justify-between items-center space-x-8">

                    <button class="text-xl md:text-3xl">
                        <i class="fas fa-bars text-white"></i>
                    </button>

                    <h1 class="text-white">
                        <a href="/" class="inline-flex flex-col items-end">
                            <span class="text-xl md:text-3xl leading-3 md:leading-6 font-semibold">
                                Elisa Modas
                            </span>

                            <span class="text-xs">
                                Tienda online
                            </span>
                        </a>
                    </h1>

                    {{-- input para la busqueda --}}
                    <div class="flex-1 hidden md:block">
                        <x-input class="w-full" placeholder="Buscar producto"/>
                    </div>

                    <div class=" flex items-center space-x-4 md:space-x-8">

                        <button class="text-xl md:text-3xl">
                            <i class="fas fa-shopping-cart text-white"></i>
                        </button>

                        <button class="text-xl md:text-3xl">
                            <i class="fas fa-user text-white"></i>
                        </button>

                    </div>

                </div>

                <div class="mt-4 md:hidden">
                        <x-input class="w-full" placeholder="Buscar producto"/>
                </div>

            </x-container>

    </header>

</div>
