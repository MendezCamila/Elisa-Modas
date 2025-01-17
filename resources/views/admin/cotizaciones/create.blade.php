<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Nueva Cotización',
    ],

]">

    {{-- Llamo a mi componente livewire --}}
    @livewire('admin.cotizaciones.create-cotizacion')


</x-admin-layout>
