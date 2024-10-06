<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Roles',
    ],

]">

    {{-- Llamo a mi componente livewire --}}
    @livewire('admin.roles.manage-roles')


</x-admin-layout>
