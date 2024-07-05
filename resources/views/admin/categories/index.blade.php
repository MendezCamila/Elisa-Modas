<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Categorias',
        'route' => route('admin.dashboard'),
    ],
]">

    <x-slot name="action">
        <a class="btn btn-blue" href="{{ route('admin.categories.create') }}">
            Nuevo
        </a>
    </x-slot>

    {{-- Tabla de Categorias --}}
    @if ($categories->count())
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Nombre
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Familia
                        </th>
                        <th scope="col" class="px-6 py-3">

                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $category->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $category->family->name }}
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.categories.edit', $category) }}">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $categories->links() }}
        </div>
    @else
        <div class="p-4  text-sm text-blue-800 rounded-lg bg-blue-50 white:bg-gray-800 dark:text-blue-400"
            role="alert">
            <span class="font-medium">Info alert!</span> Todavia no hay categorias de productos registradas.
        </div>
    @endif

</x-admin-layout>
