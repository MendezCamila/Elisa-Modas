<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Respuesta Cotizacion',
    ],

]">

    {{-- Llamo a mi componente livewire para mostrar la respuesta de la cotizacion--}}
    @livewire('admin.cotizaciones.respuesta-admin')



</x-admin-layout>
