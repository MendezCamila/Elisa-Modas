<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Nueva Cotizacion',
    ],

]">

    {{-- Llamo a mi componente livewire --}}
    @livewire('admin.cotizaciones.show-cotizacion', ['id' => $id])


</x-admin-layout>
