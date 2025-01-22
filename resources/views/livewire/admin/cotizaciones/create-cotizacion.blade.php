<div>
    <x-validation-errors class="mb-4" />
    <section class="card">


        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Crear Nueva Cotización</span>
            </h1>
        </header>

        <div class="px-6 py-4">
            <form wire:submit.prevent="createCotizacion">

                <div class="mb-4">
                    <x-label for="name" value="Nombre" />

                </div>



                {{-- Seleccionar las subcategorias --}}
                <div class="mb-4" wire:ignore>
                    <x-label for="subcategory_id" value="Subcategorías" />

                    <select name="" id="subcategories" class="w-full" wire:model="subcategory_ids">
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">
                                {{ $subcategory->name }} ({{ $subcategory->category->name }} -
                                {{ $subcategory->category->family->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

            

                {{-- Seleccionar las variantes --}}
                <div class="mb-4" >
                    <x-label for="variant_ids" value="Variantes Select2" />
                    <select  id="variants" class="w-full" multiple="multiple" wire:model="variant_ids">
                        @foreach ($variants as $variant)
                        {{ var_dump($variant) }}
                            <option value="{{ $variant['id'] }}">{{ $variant['name'] }}</option>
                            
                        @endforeach
                    </select>
                    {{--  @dump($variants)--}}
                </div>



                {{-- Selección de variantes
                @dump($variants) --}}
                <div>
                    <x-label for="variant_id" value="Variante" />
                    <select id="variant_id" class="w-full" wire:model="variant_id">

                        @foreach ($variants as $variant)
                            {{ var_dump($variant) }}
                            <option value="{{ $variant['id'] }}">{{ $variant['name'] }}</option>
                        @endforeach
                    </select>
                    {{--  @dump($variants)--}}
                </div>



            </form>
        </div>

    </section>
</div>

@assets
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endassets


{{--  
@script
    <script>
        $(document).ready(function() {
            function initializeSelect2() {
                $('#subcategories').select2();
                $('#subcategories').on('change', function(event) {
                    @this.set('subcategory_ids', $(this).val());
                });
            }

            initializeSelect2(); // Inicializar en la primera carga

            Livewire.on('initializeSelect2', function() {
                setTimeout(function() {
                    $('#subcategories').select2(
                        'destroy'); // Destruye select2 antes de volver a aplicarlo
                    initializeSelect2(); // Vuelve a inicializar select2 después de renderizar
                }, 100); // Retardo de 100ms para dar tiempo al DOM a estabilizarse
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            function initializeSelect2() {
                $('#variants').select2();
                $('#variants').on('change', function(event) {
                    @this.set('variant_ids', $(this).val());
                });
            }

            initializeSelect2(); // Inicializar en la primera carga

            Livewire.on('initializeSelect2', function() {
                setTimeout(function() {
                    $('#variants').select2(
                        'destroy'); // Destruye select2 antes de volver a aplicarlo
                    initializeSelect2(); // Vuelve a inicializar select2 después de renderizar
                }, 100); // Retardo de 100ms para dar tiempo al DOM a estabilizarse
            });
        });
    </script>
@endscript --}}

@script
<script>
    $(document).ready(function() {
        function initializeSelect2() {
            $('#subcategories').select2();
            $('#subcategories').on('change', function(event) {
                @this.set('subcategory_ids', $(this).val());
            });

            $('#variants').select2();
            $('#variants').on('change', function(event) {
                @this.set('variant_ids', $(this).val());
            });
        }

        initializeSelect2(); // Inicializar en la primera carga
        Livewire.on('initializeSelect2', function() {
                setTimeout(function() {
                    $('#subcategories').select2(
                        'destroy'); // Destruye select2 antes de volver a aplicarlo
                    $('#variants').select2('destroy'); // Destruye select2 antes de volver a aplicarlo  
                    initializeSelect2(); // Vuelve a inicializar select2 después de renderizar
                }, 100); // Retardo de 100ms para dar tiempo al DOM a estabilizarse
            });
        });
    </script>
@endscript


