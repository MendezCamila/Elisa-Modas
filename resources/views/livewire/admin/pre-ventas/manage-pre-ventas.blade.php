<div>
    <section class="rounded-lg bg-white shadow-lg">

        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Gestión de preventas</span>
            </h1>
        </header>

        {{-- Botón para agregar un nuevo usuario --}}
        <x-slot name="action">
            <a class="btn btn-blue mr-2" href="{{ route('admin.pre-ventas.create') }}">
                Nueva Preventa
            </a>
        </x-slot>

        {{-- Mostrar mensajes de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        {{-- llamo a mi componente IndexTable de PREVENTAS --}}
        @livewire('admin.pre-ventas.index-table')




    </section>
</div>
