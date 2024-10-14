<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Editar Proveedor',

    ],

]">


    {{-- Llamo a mi componente livewire le paso el proveedor que quiero editar--}}
    @livewire('admin.suppliers.edit-suppliers', ['supplier' => $supplier])


</x-admin-layout>
