<x-admin-layout :breadcrumbs="[
    [
        'name'=> 'Dashboard',
    ],
]">

    {{-- Presentacion Usuario, nombre tienda --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center">
                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                    alt="{{ Auth::user()->name }}" />

                <div class="ml-4 flex-1">
                    <h2 class="text-lg font-semibold">
                        Bienvenido, {{ Auth()->user()->name }}
                    </h2>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-sm hover:text-blue-500">
                            Cerrar sesion
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-lg p-6 flex items-center justify-center">
            <h2 class="text-xl font-semibold">
                Elisa Modas
            </h2>
        </div>
    </div>

    {{-- Estadisticas --}}

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
        <!-- Ingresos mensuales -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold">Ingresos Mensuales</h3>
            <p class="text-2xl font-bold text-green-600"> ARS</p>
        </div>

        <!-- Productos más vendidos -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold">Productos más vendidos</h3>
            <ul>

            </ul>
        </div>

        <!-- Productos con stock bajo -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold">Stock bajo</h3>
            <ul>

            </ul>
        </div>
    </div>


</x-admin-layout>
