<div>
    <x-validation-errors class="mb-4" />
    <section class="card">

        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Crear Nuevo Proveedor</span>
            </h1>
        </header>

        <div class="px-6 py-4">
            <form wire:submit.prevent="createSupplier">

                <div class="mb-4">
                    <x-label for="name" value="Nombre" />
                    <x-input id="name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" wire:model="name" required autofocus />
                </div>

                <div class="mb-4">
                    <x-label for="last_name" value="Apellido" />
                    <x-input id="last_name" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" wire:model="last_name" required />
                </div>

                <div class="mb-4">
                    <x-label for="cuit" value="CUIT" />
                    <x-input id="cuit" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" wire:model="cuit" required />
                </div>

                <div class="mb-4">
                    <x-label for="email" value="Email" />
                    <x-input id="email" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="email" wire:model="email" required />
                </div>

                <div class="mb-4">
                    <x-label for="phone" value="Teléfono" />
                    <x-input id="phone" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm" type="text" wire:model="phone" />
                </div>

                {{-- Seleccionar las subcategorias --}}
                <div class="mb-4" wire:ignore>
                    <x-label for="subcategory_id" value="Subcategorías" />

                    <select name="" id="subcategories" class="w-full" multiple="multiple"  wire:model="subcategory_ids" >
                        @foreach($subcategories as $subcategory)
                            <option value="{{ $subcategory->id }}">
                                {{ $subcategory->name }} ({{ $subcategory->category->name }} - {{ $subcategory->category->family->name }})
                            </option>
                        @endforeach
                    </select>

                </div>


                <div class="flex justify-end mt-4">
                    <x-button>
                        Crear Proveedor
                    </x-button>
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


@script
    <script>
        $(document).ready(function() {
            function initializeSelect2() {
                $('#subcategories').select2();
                $('#subcategories').on('change', function (event) {
                    @this.set('subcategory_ids', $(this).val());
                });
            }

            initializeSelect2(); // Inicializar en la primera carga

            Livewire.on('initializeSelect2', function() {
                setTimeout(function() {
                    $('#subcategories').select2('destroy'); // Destruye select2 antes de volver a aplicarlo
                    initializeSelect2(); // Vuelve a inicializar select2 después de renderizar
                }, 100); // Retardo de 100ms para dar tiempo al DOM a estabilizarse
            });
        });
    </script>
@endscript






















