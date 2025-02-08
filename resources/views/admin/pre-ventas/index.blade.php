<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Pre-ventas',
    ],

]">

    @livewire('admin.pre-ventas.manage-pre-ventas')

</x-admin-layout>
