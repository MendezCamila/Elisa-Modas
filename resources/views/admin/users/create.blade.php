<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Crear Usuario',

    ],

]">

    
    {{-- Llamo a mi componente livewire le paso los roles--}}
    @livewire('admin.users.create-users', ['roles' => $roles])


</x-admin-layout>
