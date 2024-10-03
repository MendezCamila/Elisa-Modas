<div>
    <section class="rounded-lg bg-white shadow-lg">

        <header class="border-b px-6 py-2 border-gray-200">
            <h1>
                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">Gestión de Usuarios</span>
            </h1>
        </header>

        {{-- Botón para agregar un nuevo usuario --}}
        <x-slot name="action">
            <a class="btn btn-blue" href="{{ route('admin.users.create') }}">
                Nuevo Usuario
            </a>
        </x-slot>

        {{-- Buscador de usuarios --}}
        <div class="px-6 py-4">
            <x-input wire:model.live="search" type="text" class="w-full rounded-md border-gray-300 shadow-sm" placeholder="Buscar usuario por nombre o email" />
        </div>

        {{-- Tabla de usuarios --}}
        @if ($users->count())
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">ID</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Apellido</th>
                            <th scope="col" class="px-6 py-3">Email</th>
                            <th scope="col" class="px-6 py-3">Teléfono</th>
                            <th scope="col" class="px-6 py-3">Rol</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $user->id }}
                                </th>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->last_name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4">{{ $user->phone }}</td>
                                <td class="px-6 py-4">
                                    @if ($user->roles->count())
                                        {{ implode(', ', $user->roles->pluck('name')->toArray()) }}
                                    @else
                                        No tiene rol
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="text-blue-600">Editar</a>
                                    <a href="" class="text-red-600">Eliminar</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Paginación --}}
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        @else
            <div class="p-4 text-sm text-blue-800 rounded-lg bg-blue-50 dark:bg-gray-800 dark:text-blue-400" role="alert">
                <span class="font-medium">No se encontraron coincidencias!</span> No hay usuarios que coincidan con "{{ $search }}".
            </div>
        @endif


    </section>
</div>

