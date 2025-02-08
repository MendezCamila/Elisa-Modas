<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Crear Preventa',
    ],

]">

    @livewire('admin.pre-ventas.create-preventas')



</x-admin-layout>
