<div class=" bg-white py-12">

    <x-container class=" px-4 flex ">

        @if ( count($options) )  {{-- Mostrar los filtros --}}
            <aside class="w-52 flex-shrink-0 mr-8 ">

                <ul class="space-y-4">
                    @foreach ($options as $option)
                        {{-- ocultar y mostrar las caracteristicas --}}
                        <li x-data="{
                            open: true,
                        }">
                            <button class="px-4 py-2 bg-gray-300 w-full text-left text-gray-700 flex justify-between items-center"
                                x-on:click="open = !open">
                                {{ $option->name }}
                                <i class="fa-solid fa-angle-down items-end"
                                    x-bind:class="{
                                        'fa-angle-down': open,
                                        'fa-angle-up': !open,
                                    }"></i>

                            </button>
                            {{-- Lista las features --}}
                            <ul class="mt-2 space-y-2" x-show="open">
                                @foreach ($option->features as $feature)
                                    <li>
                                        <label class="inline-flex items-center">
                                            <x-checkbox class="mr-2" />
                                            {{ $feature->description }}
                                        </label>
                                    </li>
                                @endforeach

                            </ul>
                        </li>
                    @endforeach
                </ul>

            </aside>
        @endif



        <div class="flex-1">


            <div class="flex items-center">{{-- div para el select de orden --}}
                <span class="mr-2">
                    Ordenar por:
                </span>

                <x-select>
                    <option value="1">
                        Relevacia
                    </option>

                    <option value="2">
                        Precio: Mayor a Menor
                    </option>

                    <option value="3">
                        Precio: Menor a Mayor
                    </option>
                </x-select>
            </div>

            <hr class="my-4">

                {{-- Mostrar los productos --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <article class="bg-white  shadow rounded overflow-hidden">
                        <img src="{{ $product->image }}" class="w-full h-48 object-cover object-center">

                        <div class="p-4">
                            <h1 class="text-lg font-bold text-gray-700 line-clamp-2 mb-2 min-h-[56px]">
                                {{ $product->name }}
                            </h1>

                            <p class="mb-4">
                                <span class="text-gray-500">Precio:</span>
                                <span class="text-gray-700 font-bold">{{ $product->price }}</span>
                            </p>

                            <a href="" class="btn btn-pink block w-full text-center">
                                Ver más
                            </a>

                        </div>

                    </article>
                @endforeach

            </div>

            <div class="mt-8">
                {{ $products->links() }}
            </div>

        </div>



    </x-container>


</div>
