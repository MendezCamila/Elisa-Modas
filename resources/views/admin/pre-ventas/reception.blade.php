<x-admin-layout :breadcrumbs="[
    ['name' => 'Dashboard', 'route' => route('admin.dashboard')],
    ['name' => 'Registrar ingreso'],
]">


        <h1 class="text-3xl font-bold text-gray-800 mb-6 ">Registrar Recepción</h1>

        <!-- Datos de la Preventa -->
        <div class="bg-gray-100 p-5 rounded-lg shadow-sm mb-6">
            <h2 class="text-xl font-semibold text-gray-700 mb-3">Detalles de la Preventa</h2>
            <div class="grid grid-cols-2 gap-4">
                <p><strong class="text-gray-600">ID:</strong> {{ $preVenta->id }}</p>
                <p><strong class="text-gray-600">Variant ID:</strong> {{ $preVenta->variant_id }}</p>
                <p><strong class="text-gray-600">Cantidad:</strong> {{ $preVenta->cantidad }}</p>
                <p><strong class="text-gray-600">Descuento:</strong> {{ $preVenta->descuento }}</p>
                <p><strong class="text-gray-600">Fecha Inicio:</strong> {{ $preVenta->fecha_inicio }}</p>
                <p><strong class="text-gray-600">Fecha Fin:</strong> {{ $preVenta->fecha_fin }}</p>
                <p class="col-span-2"><strong class="text-gray-600">Estado:</strong>
                    <span class="px-2 py-1 rounded-md
                        {{ $preVenta->estado == 'activo' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ ucfirst($preVenta->estado) }}
                    </span>
                </p>
            </div>
        </div>

        <!-- Formulario de Recepción -->
        <form action="{{ route('admin.pre-ventas.registerReception', $preVenta) }}" method="POST" class="bg-gray-50 p-5 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="cantidadRecibida" class="block text-gray-700 font-medium mb-1">Cantidad Recibida:</label>
                <input type="number" name="cantidadRecibida" id="cantidadRecibida" class="w-full border-gray-300 rounded-md p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Ingrese la cantidad recibida" required>
                @error('cantidadRecibida')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex justify-between items-center mt-6">
                <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                    Registrar Recepción
                </button>
                <a href="{{ route('admin.pre-ventas.index') }}" class="text-gray-600 hover:text-gray-900 transition duration-300">
                    Cancelar
                </a>
            </div>
        </form>


</x-admin-layout>
