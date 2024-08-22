<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Opciones',
        //'route' => route('admin.products.index'),
    ],
]">

    {{-- Llamo a mi componente livewire--}}
    @livewire('admin.options.manage-options')


</x-admin-layout>
