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
            <x-input wire:model.live="search" type="text" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Buscar proveedor por nombre o email" />
        </div>

        {{-- Tabla de proveedores --}}
        @if ($suppliers->count())
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Apellido</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Teléfono</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($suppliers as $supplier)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $supplier->id }}
                                </th>
                                <td class="px-6 py-4">{{ $supplier->name }}</td>
                                <td class="px-6 py-4">{{ $supplier->last_name }}</td>
                                <td class="px-6 py-4">{{ $supplier->email }}</td>
                                <td class="px-6 py-4">{{ $supplier->phone }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <a href="{{ route('admin.suppliers.edit', $supplier) }}" class="text-blue-600 text-xs flex items-center space-x-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        <span>Editar</span>
                                    </a>
                                    <a href="javascript:void(0);" onclick="confirmDelete({{ $supplier->id }})" class="text-red-600 text-xs flex items-center space-x-1">
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
            <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <span class="font-medium">No se encontraron coincidencias!</span> No hay proveedores que coincidan con "{{ $search }}".
            </div>
        @endif

    </section>

    <form action="" method="POST" id="delete-form">
        @csrf
        @method('DELETE')
    </form>

    @push('js')
        <script>
            function confirmDelete(supplierId) {
                Swal.fire({
                    title: "Estas seguro?",
                    text: "No podras revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, borralo!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.getElementById('delete-form');
                        form.action = `/admin/suppliers/${supplierId}`;
                        form.submit();
                    }
                });
            }
        </script>
    @endpush
</div>
