<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Proveedores',
    ],

]">

    {{-- Llamo a mi componente livewire --}}
    @livewire('admin.suppliers.manage-suppliers')


</x-admin-layout>
