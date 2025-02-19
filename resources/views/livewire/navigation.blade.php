<div x-data="{
    open: false,
}">

    {{-- Encabezado --}}
    <header class="bg-pink-500">

        <x-container class="px-4 py-4">

            <div class="flex justify-between items-center space-x-8">

                <button class="text-xl md:text-3xl" x-on:click="open = true">
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
                    <x-input oninput="search(this.value)" class="w-full" placeholder="Buscar producto" />
                </div>

                <div class=" flex items-center space-x-4 md:space-x-8">


                    {{-- Del carrito --}}
                    <a href="{{ route('cart.index') }}" class="relative">
                        <i class="fas fa-shopping-cart text-white text-xl md:text-3xl"></i>

                        <span id="cart-count"
                            class="absolute -top-2 -end-4 inline-flex items-center justify-center w-6 h-6 bg-red-600 rounded-full text-xs text-white font-bold">
                            {{ Cart::instance('shopping')->count() }}
                        </span>
                    </a>

                    {{-- Del Usuario --}}
                    <x-dropdown>

                        <x-slot name="trigger">

                            @auth
                                <button
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img class="h-8 w-8 rounded-full object-cover"
                                        src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </button>
                            @else
                                <button class="text-xl md:text-3xl">
                                    <i class="fas fa-user text-white"></i>
                                </button>
                            @endauth
                        </x-slot>


                        <x-slot name="content">
                            @guest
                                <div class="px-4 py-2">
                                    <div class="flex justify-center">
                                        <a href="{{ route('login') }}" class="btn btn-pink">
                                            Iniciar sesión
                                        </a>
                                    </div>

                                    <p class="text-sm text-center mt-2">
                                        No tienes una cuenta? <a href="{{ route('register') }}"
                                            class="text-pink-500 hover:underline ">Regístrate</a>
                                    </p>

                                </div>
                            @else
                                <x-dropdown-link href="{{ route('profile.show') }}">
                                    Mi perfil
                                </x-dropdown-link>

                                {{-- Mis compras (parte cliente) --}}
                                <x-dropdown-link href="{{ route('purchases.index') }}">
                                    Mis compras
                                </x-dropdown-link>

                                {{-- Panel Admin (solo visible para usuarios con el permiso 'acceso dashboard') --}}
                                @can('acceso dashboard')
                                    <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                        Panel Admin
                                    </x-dropdown-link>
                                @endcan

                                <div class="border-t border-gray-200">
                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}" x-data>
                                        @csrf

                                        <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                            {{ __('Log Out') }}
                                        </x-dropdown-link>
                                    </form>
                                </div>

                            @endguest
                        </x-slot>
                    </x-dropdown>
                </div>

            </div>

            <div class="mt-4 md:hidden">
                <x-input oninput="search(this.value)" class="w-full" placeholder="Buscar producto" />
            </div>

        </x-container>

    </header>

    <div x-show="open" x-on:click="open= false" style="display:none"
        class="fixed top-0 left-0 inset-0 bg-black bg-opacity-25 z-10"></div>

    {{-- Menu --}}
    <div x-show="open" style="display:none" class="fixed top-0 left-0 z-20">

        <div class="flex">

            <div class="w-screen md:w-80  h-screen bg-white">
                {{-- Parte de arriba --}}
                <div class="bg-pink-500 px-4 py-3 text-white font-semibold">
                    <div class="flex justify-between items-center">
                        <span class="text-lg">
                            ¡Hola!
                        </span>

                        <button x-on:click="open= false">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                {{-- Columna de abajo --}}
                <div class="h-[calc(100vh-52px)] overflow-auto">

                    <ul>
                        @foreach ($families as $family)
                            <li wire:mouseover ="$set('family_id', {{ $family->id }})">
                                <a href="{{ route('families.show', $family) }}"
                                    class=" flex items-center justify-between px-4 py-4 text-gray-700 hover:bg-pink-200">
                                    {{ $family->name }}

                                    <i class="fa-solid fa-angle-right"></i>
                                </a>

                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

            {{-- menu que se abre --}}
            <div class="w-96 xl:w-[57rem] pt-[52px] hidden md:block">

                <div class=" bg-white h-[calc(100vh-52px)] overflow-auto px-6 py-8">

                    <div class="mb-8 flex pb-1 justify-between items-center">
                        <p class="border-b-[3px] uppercase text-xl font-semibold border-gray-700">
                            {{ $this->familyName }}
                        </p>

                        <a href="{{ route('families.show', $family_id) }}" class="btn btn-pink"> Ver todo</a>

                    </div>



                    <ul class="grid grid-cols-1 xl:grid-cols-3 gap-8">

                        @foreach ($this->categories as $category)
                            <li>
                                <a href="{{ route('categories.show', $category) }}"
                                    class="text-pink-500 font-semibold text-lg">
                                    {{ $category->name }}
                                </a>

                                <ul class="mt-4 space-y-2">

                                    {{-- Subcategorias --}}
                                    @foreach ($category->subcategories as $subcategory)
                                        <li>
                                            <a href="{{ route('subcategories.show', $subcategory) }}"
                                                class="text-sm text-gray-700 hover:text-pink-500">
                                                {{ $subcategory->name }}

                                            </a>
                                        </li>
                                    @endforeach
                                </ul>

                            </li>
                        @endforeach
                    </ul>
                </div>

            </div>




        </div>

    </div>

    @push('js')
        <script>
            Livewire.on('cartUpdated', (count) => {
                document.getElementById('cart-count').innerText = count;
            });

            function search(value) {
                Livewire.dispatch('search', {
                    search: value
                });
            }
        </script>
    @endpush

</div>
