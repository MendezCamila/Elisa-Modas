<x-admin-layout :breadcrumbs="[
    [
        'name' => 'Dashboard',
        'route' => route('admin.dashboard'),
    ],
    [
        'name' => 'Registrar ingreso',
    ],

]">

    <div class="card">
        <h1 class="text-2xl font-bold mb-4">Registrar Recepción</h1>

    <!-- Mostrar datos de la Preventa -->
    <div class="mb-6 p-4 bg-white rounded shadow">
        <h2 class="text-xl mb-2">Datos de la Preventa</h2>
        <p><strong>ID:</strong> {{ $preVenta->id }}</p>
        <p><strong>Variant ID:</strong> {{ $preVenta->variant_id }}</p>
        <p><strong>Cantidad:</strong> {{ $preVenta->cantidad }}</p>
        <p><strong>Descuento:</strong> {{ $preVenta->descuento }}</p>
        <p><strong>Fecha Inicio:</strong> {{ $preVenta->fecha_inicio }}</p>
        <p><strong>Fecha Fin:</strong> {{ $preVenta->fecha_fin }}</p>
        <p><strong>Estado:</strong> {{ $preVenta->estado }}</p>
    </div>

    <!-- Formulario para registrar la recepción -->
    <form action="{{ route('admin.pre-ventas.registerReception', $preVenta) }}" method="POST" class="bg-white p-6 rounded shadow">
        @csrf
        <div class="mb-4">
            <label for="cantidadRecibida" class="block text-gray-700">Cantidad recibida:</label>
            <input type="number" name="cantidadRecibida" id="cantidadRecibida" class="border rounded p-2 w-full" placeholder="Ingrese la cantidad recibida" required>
            @error('cantidadRecibida')
                <span class="text-red-500">{{ $message }}</span>
            @enderror
        </div>
        <div class="flex items-center">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
                Registrar Recepción
            </button>
            <a href="{{ route('admin.pre-ventas.index') }}" class="ml-4 text-gray-700 hover:underline">
                Cancelar
            </a>
        </div>
    </form>

    </div>



</x-admin-layout>
