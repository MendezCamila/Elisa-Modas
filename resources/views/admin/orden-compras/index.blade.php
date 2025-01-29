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
        <a href="#" id="export-pdf" class="btn btn-primary">Exportar a PDF</a>
    </div>

    @livewire('admin.orden-compra.index-table')


    <script>
        document.getElementById('export-pdf').addEventListener('click', function(event) {
            event.preventDefault();
            let url = new URL('{{ route('admin.orden-compras.pdf') }}');
            let params = new URLSearchParams(window.location.search);
            url.search = params.toString();
            window.location.href = url.toString();
        });
    </script>


</x-admin-layout>


