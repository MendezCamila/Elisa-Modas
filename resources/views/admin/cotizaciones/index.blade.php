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


</x-admin-layout>
