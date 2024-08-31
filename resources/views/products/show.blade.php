<x-app-layout>

    {{-- Migas de pan --}}
    <x-container class="px-4 my-4">
        <nav class="flex" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
            <li class="inline-flex items-center">
                <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-pink-600 dark:text-gray-400 dark:hover:text-pink">
                <svg class="w-3 h-3 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                </svg>
                Home
                </a>
            </li>

            {{-- Mostrar la familia --}}
            <li>
                <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>

                <a href="{{ route('families.show',$product->subcategory->category->family) }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-pink-600 md:ms-2 dark:text-gray-400 dark:hover:text-pink">
                    {{ $product->subcategory->category->family->name }}
                </a>

                </div>
            </li>

            {{-- Mostrar la categoria --}}
            <li>
                <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>

                <a href="{{ route('categories.show',$product->subcategory->category) }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-pink-600 md:ms-2 dark:text-gray-400 dark:hover:text-pink">
                    {{ $product->subcategory->category->name }}
                </a>

                </div>
            </li>

            <li>
                <div class="flex items-center">
                <svg class="rtl:rotate-180 w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                </svg>

                <a href="{{ route('categories.show',$product->subcategory->name) }}" class="ms-1 text-sm font-medium text-gray-700 hover:text-pink-600 md:ms-2 dark:text-gray-400 dark:hover:text-pink">
                    {{ $product->subcategory->name }}
                </a>

                </div>
            </li>

            {{-- Mostrar el producto --}}

            </ol>
        </nav>
    </x-container>

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

                    <div class="flex space-x-6 items-center mb-6">
                        <button class="btn btn-gray">
                            -
                        </button>

                        <span>
                            1
                        </span>

                        <button class="btn btn-gray">
                            +
                        </button>
                    </div>

                    <button class="btn btn-pink w-full mb-6">
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




</x-app-layout>
