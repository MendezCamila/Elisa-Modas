<div class="card">
    <x-validation-errors class="mb-4" />
    <form wire:submit.prevent="submit">
        <div class="mb-4">
            <x-label for="variant_id" value="Variante" />
            <select wire:model="variant_id" id="variant_id" class="block mt-1 w-full">
                <option value="">Seleccione una variante</option>
                @foreach ($variants as $variant)
                    <option value="{{ $variant['id'] }}">{{ $variant['name'] }}</option>
                @endforeach
            </select>
            <x-input-error for="variant_id" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-label for="pool" value="Cantidad de unidades disponibles" />
            <x-input wire:model="pool" id="pool" type="number" class="block mt-1 w-full" />
            <x-input-error for="pool" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-label for="descuento" value="Descuento (%)" />
            <x-input wire:model="descuento" id="descuento" type="number" class="block mt-1 w-full" />
            <x-input-error for="descuento" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-label for="start_date" value="Fecha de inicio" />
            <x-input wire:model="start_date" id="start_date" type="date" class="block mt-1 w-full" />
            <x-input-error for="start_date" class="mt-2" />
        </div>

        <div class="mb-4">
            <x-label for="end_date" value="Fecha de fin" />
            <x-input wire:model="end_date" id="end_date" type="date" class="block mt-1 w-full" />
            <x-input-error for="end_date" class="mt-2" />
        </div>

        <div class="flex justify-between">
            {{-- Botón para volver atrás --}}
            <button onclick="window.history.back()"
                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                Volver Atrás
            </button>

            <x-button>
                Crear Preventa
            </x-button>
        </div>
    </form>
</div>

@assets
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endassets


<script>
    $(document).ready(function() {
        function initializeSelect2() {
            $('#variant_id').select2();
            $('#variant_id').on('change', function(event) {
                @this.set('variant_id', $(this).val());
            });
        }

        initializeSelect2(); // Inicializar en la primera carga

        Livewire.on('initializeSelect2', function() {
            setTimeout(function() {
                $('#variant_id').select2('destroy'); // Destruye select2 antes de volver a aplicarlo
                initializeSelect2(); // Vuelve a inicializar select2 después de renderizar
            }, 100); // Retardo de 100ms para dar tiempo al DOM a estabilizarse
        });
    });
</script>

