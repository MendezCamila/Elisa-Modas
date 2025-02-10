<x-app-layout>


    @push('css')
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        />

    @endpush

    <!-- Slider Portadas -->
    <div class="swiper mb-12">
        <!-- Additional required wrapper -->
        <div class="swiper-wrapper">
        <!-- Slides -->
            @foreach ($covers as $cover)

                <div class="swiper-slide">
                    {{--  <img src="{{ $cover->image }}" alt="" class="w-full aspect-[3/1] object-cover object-center">--}}
                    <img src="{{ $cover->image }}" alt="" class="w-full aspect-[3/1] object-contain bg-white">

                </div>
            @endforeach

    </div>
        <!-- If we need pagination -->
    <div class="swiper-pagination"></div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next "></div>

    </div>

    <x-container>
        <h1>
            <span class="text-2xl font-bold text-gray-800 mb-4">Últimos Productos</span>
        </h1>

        {{-- Mostrar los productos --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <article class="bg-white shadow rounded overflow-hidden">
                    <img src="{{ $product->image }}" class="w-full h-48 object-cover object-center">

                    <div class="p-4">
                        <h1 class="text-lg font-bold text-gray-700 line-clamp-2 mb-2 min-h-[56px]">
                            {{ $product->name }}
                        </h1>

                        <p class="mb-4">
                            <span class="text-gray-500">Precio:</span>
                            @if(isset($product->is_preventa) && $product->is_preventa)
                                <span class="text-red-500 font-bold">{{ $product->price * (1 - $product->preventa_descuento / 100) }}</span>
                                <span class="text-gray-500 line-through">{{ $product->price }}</span>
                                <span class="text-green-500 font-bold">Pre-venta</span>
                            @else
                                <span class="text-gray-700 font-bold">{{ $product->price }}</span>
                            @endif
                        </p>

                        @if(isset($product->is_preventa) && $product->is_preventa)
                            <a href="" class="btn btn-pink block w-full text-center">
                                Reservar
                            </a>
                        @else
                            <a href="{{ route('products.show', $product) }}" class="btn btn-pink block w-full text-center">
                                Ver más
                            </a>
                        @endif
                    </div>
                </article>
            @endforeach
        </div>

    </x-container>



    @push('js')

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

        <script>
            const swiper = new Swiper('.swiper', {
            // Optional parameters
            loop: true,

            autoplay: {
                delay: 5000,
            },

            // If we need pagination
            pagination: {
                el: '.swiper-pagination',
            },

            // Navigation arrows
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            });
        </script>

    @endpush


</x-app-layout>

