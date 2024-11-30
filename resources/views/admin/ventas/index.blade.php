<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ventas',
    ],

]">

    {{-- Llamo a mi componente de livewire que cree con php artisan make:datatable admin.ventas.venta-table Ventas --}}
    @livewire('admin.ventas.VentaTable')


</x-admin-layout>
