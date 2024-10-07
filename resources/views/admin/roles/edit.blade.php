<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',

    ],

]">


    {{-- Llamo a mi componente livewire --}}


    @livewire('admin.roles.edit-roles', ['roleId' => $role->id])
</x-admin-layout>
