<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Orden de compras',
    ],

]">

    {{-- @livewire('admin.orden-compra.manage-orden-compras') --}}

    <div class="mb-4">
        <a href="{{ route('admin.orden-compras.pdf') }}" class="btn btn-primary">Exportar a PDF</a>
    </div>

    @livewire('admin.orden-compra.index-table')



</x-admin-layout>
