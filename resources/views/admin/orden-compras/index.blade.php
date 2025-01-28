<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Orden de compras',
    ],

]">

    @livewire('admin.orden-compra.manage-orden-compras')

    @livewire('admin.orden-compra.index-table')



</x-admin-layout>
