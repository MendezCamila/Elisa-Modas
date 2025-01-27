<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Crear orden de compra',
    ],

]">

    @livewire('admin.orden-compra.create-orden-compra',  ['cotizacionId' => $cotizacion->id])



</x-admin-layout>
