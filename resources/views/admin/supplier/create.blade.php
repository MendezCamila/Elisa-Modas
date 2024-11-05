<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Nuevo Proveedor',

    ],

]">


    {{-- Llamo a mi componente livewire--}}
    @livewire('admin.suppliers.create-suppliers')


</x-admin-layout>
