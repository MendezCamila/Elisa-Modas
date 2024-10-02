<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Usuarios',

    ],

]">

    
    {{-- Llamo a mi componente livewire y le paso el usuario y los roles --}}
    @livewire('admin.users.edit-users', ['user' => $user, 'roles' => $roles])


</x-admin-layout>
