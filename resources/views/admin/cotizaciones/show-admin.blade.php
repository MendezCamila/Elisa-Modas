<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Cotizacion',
    ],

]">

    {{-- Llamo a mi componente livewire para mostrar la cotizacion--}}
    @livewire('admin.cotizaciones.show-admin-cotizacion',  ['cotizacionId' => $cotizacion->id])


</x-admin-layout>
