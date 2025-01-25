<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Cotizaciones',
    ],

]">

    {{-- Llamo a mi componente livewire --}}
    @livewire('admin.cotizaciones.manage-cotizaciones')


    {{-- llamo a mi componente IndexTable
    @livewire('admin.cotizaciones.index-table')--}}



</x-admin-layout>
