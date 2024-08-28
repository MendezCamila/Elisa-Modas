<div class=" bg-white py-12">

    <x-container class=" px-4 flex ">

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

        <div class="flex-1">


        </div>

    </x-container>


</div>
