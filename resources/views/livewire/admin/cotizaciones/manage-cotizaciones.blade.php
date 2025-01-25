<div>
    <section class="rounded-lg bg-white shadow-lg">

        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Gestión de cotización</span>
            </h1>
        </header>

        {{-- Botón para agregar un nuevo usuario --}}
        <x-slot name="action">
            <a class="btn btn-blue" href="{{ route('admin.cotizaciones.create') }}">
                Nueva Cotización
            </a>
        </x-slot>

        

        {{-- Tabla Cotizacion --}}
        {{-- llamo a mi componente IndexTable --}}
        @livewire('admin.cotizaciones.index-table')



    </section>
</div>
