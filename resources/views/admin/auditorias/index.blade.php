<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Auditorias',
        'route' => route('admin.dashboard'),
    ],
]">
    @livewire('admin.auditorias.audit-table')

</x-admin-layout>
