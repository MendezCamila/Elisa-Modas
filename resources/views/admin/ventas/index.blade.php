<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Ventas',
    ],
]">

    <div class="mb-4">
        <a href="#" id="export-pdf"
            class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold py-2 px-4 rounded shadow transition duration-200 flex items-center">
            Exportar a PDF
            <img class="h-6 ml-2" src="/img/iconos/pdf.png" alt="PDF Icon">
        </a>
    </div>

    {{-- Llamo a mi componente de livewire que cree con php artisan make:datatable admin.ventas.venta-table Ventas --}}
    @livewire('admin.ventas.VentaTable')


    <script>
        document.getElementById('export-pdf').addEventListener('click', function(event) {
            event.preventDefault();
            let url = new URL('{{ route('admin.ventas.informepdf') }}');
            let params = new URLSearchParams(window.location.search);
            url.search = params.toString();
            window.location.href = url.toString();
        });
    </script>



</x-admin-layout>
