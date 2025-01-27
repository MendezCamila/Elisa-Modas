<div>
    <section class="rounded-lg bg-white shadow-lg">

        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Gestión de cotización</span>
            </h1>
        </header>

        {{-- Botón para agregar un nuevo usuario --}}
        <x-slot name="action">
            <a class="btn btn-blue mr-2" href="{{ route('admin.cotizaciones.create') }}">
                Nueva Cotización
            </a>

            <a class="btn bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg ml-2"
                href="{{ route('admin.cotizaciones.generar') }}">
                Generar Cotización
            </a>
        </x-slot>

        {{-- Mostrar mensajes de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        {{-- llamo a mi componente IndexTable Tabla Cotizacion --}}
        @livewire('admin.cotizaciones.index-table')



    </section>
</div>
