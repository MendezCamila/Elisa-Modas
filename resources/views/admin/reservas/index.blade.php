<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Reservas',
    ],

]">

    {{-- Llamo a mi componente livewire --}}
   @livewire('admin.reservas.index-table')


</x-admin-layout>
