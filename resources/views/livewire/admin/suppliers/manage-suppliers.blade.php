<div>
    <section class="rounded-lg bg-white shadow-lg">

        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Gestión de Proveedores</span>
            </h1>
        </header>

        {{-- Botón para agregar un nuevo proveedor --}}
        <x-slot name="action">
            <a class="btn btn-blue" href="{{ route('admin.suppliers.create') }}">
                Nuevo Proveedor
            </a>
        </x-slot>

        {{-- Buscador de proveedores --}}
        <div class="px-6 py-4">
            <x-input wire:model.live="search" type="text" class="w-full rounded-md border-gray-300 shadow-sm"
                placeholder="Buscar proveedor por nombre, email o CUIT" />
        </div>

        {{-- Tabla de proveedores --}}
        @if ($suppliers->count())
            <div class="overflow-x-auto">
                <table class="min-w-full w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-4 py-2 w-1/12">ID</th>
                            <th class="px-4 py-2 w-2/12">Nombre</th>
                            <th class="px-4 py-2 w-2/12">Apellido</th>
                            <th class="px-4 py-2 w-2/12">CUIT</th>
                            <th class="px-4 py-2 w-3/12">Email</th>
                            <th class="px-4 py-2 w-2/12">Teléfono</th>
                            <th class="px-4 py-2 w-1/12">Estado</th>
                            <th class="px-4 py-2 w-2/12">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr
                                class="{{ $supplier->estado === 'no activo' ? 'bg-red-100' : 'bg-white' }} border-b dark:bg-gray-800 dark:border-gray-700">
                                <td class="px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $supplier->id }}</td>
                                <td class="px-4 py-2">{{ $supplier->name }}</td>
                                <td class="px-4 py-2">{{ $supplier->last_name }}</td>
                                <td class="px-4 py-2">{{ $supplier->cuit }}</td>
                                <td class="px-4 py-2 truncate">{{ $supplier->email }}</td>
                                <td class="px-4 py-2">{{ $supplier->phone }}</td>
                                <td class="px-4 py-2">
                                    <span
                                        class="{{ $supplier->estado === 'activo' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ ucfirst($supplier->estado) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('admin.suppliers.edit', $supplier) }}"
                                        class="text-blue-600 text-xs flex items-center space-x-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Editar</span>
                                    </a>
                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $supplier->id }})"
                                        class="text-red-600 text-xs flex items-center space-x-1">
                                        <i class="fa-solid fa-trash-can"></i>
                                        <span>Eliminar</span>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $suppliers->links() }}
            </div>
        @else
            <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400"
                role="alert">
                <span class="font-medium">No se encontraron coincidencias!</span> No hay proveedores que coincidan con
                "{{ $search }}".
            </div>
        @endif

    </section>



    @push('js')
        <script>
            function confirmDelete(supplierId) {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Este proveedor será marcado como no activo.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sí, desactivar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Llama al método de Livewire para desactivar el proveedor
                        @this.call('desactivarSupplier', supplierId);
                    }
                });
            }
        </script>
    @endpush

</div>
