<!-- Incluye la biblioteca de ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<x-admin-layout :breadcrumbs="[
    [
        'name'=> 'Dashboard',
    ],
]">

    {{-- Presentación Usuario, nombre tienda--}}
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
                            Cerrar sesión
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

    {{-- Filtros --}}
    <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
        <form method="GET" action="{{ url('admin/dashboard') }}" onsubmit="return validateDates()">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Fecha Inicio y Fecha Fin -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio:</label>
                        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    </div>
                    <div>
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Fin:</label>
                        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}"
                            class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                    </div>
                </div>

                <!-- Subcategoría -->
                <div class="col-span-2">
                    <label for="subcategory" class="block text-sm font-medium text-gray-700">Subcategoría:</label>
                    <select id="subcategory" name="subcategory"
                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        <option value="">Todas</option>
                        @foreach ($subcategories as $subcategory)
                            <option value="{{ $subcategory->name }}" {{ $selectedSubcategory == $subcategory->name ? 'selected' : '' }}>
                                {{ $subcategory->name }} ({{ $subcategory->category->name }} - {{ $subcategory->category->family->name }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Botón Filtrar -->
            <div class="mt-4 flex justify-end">
                <x-button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Filtrar
                </x-button>
            </div>
        </form>
    </div>

    {{-- Estadísticas --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Ventas -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-lg font-semibold">Ventas</h3>
            <div id="chart" style="height: 400px;"></div>
        </div>

        <!-- Subcategorías más vendidas -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold">Subcategorías más vendidas</h3>
            <div id="unidadesChart" style="height: 400px;"></div>
        </div>
    </div>

</x-admin-layout>




<script>
        $(document).ready(function() {
            $('#subcategory').select2();
        });

        function validateDates() {
            var startDate = document.getElementById('start_date').value;
            var endDate = document.getElementById('end_date').value;

            if (new Date(endDate) < new Date(startDate)) {
                alert('La fecha de fin no puede ser menor que la fecha de inicio.');
                return false;
            }
            return true;
        }

        // Verifica que los datos de ventas no estén vacíos
        var ventasData = @json($ventas);  // Los datos pasan desde PHP a JavaScript
        var promedioVentas = @json($promedioVentas);  // El promedio global de ventas

        if (!ventasData || ventasData.length === 0) {
            console.error('No hay datos de ventas disponibles.');
        } else {
            // Configuración del gráfico
            var options = {
                chart: {
                    type: 'bar',  // Tipo de gráfico: columna
                },
                series: [{
                    name: 'Ventas',
                    data: ventasData.map(function (item) {
                        return {
                            x: 'Mes ' + item.month,  // Usamos el mes como categoría
                            y: item.total  // Total de ventas
                        };
                    })
                }],
                xaxis: {
                    type: 'category',  // El eje X es de tipo categoría
                    title: {
                        text: 'Meses'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Ventas Totales'
                    },
                    // Para agregar una línea horizontal en el gráfico para el promedio
                    min: 0,  // Establecemos un mínimo en 0
                },
                annotations: {
                    yaxis: [{
                        y: promedioVentas,
                        borderColor: '#FF0000',
                        label: {
                            text: 'Promedio Anual: ' + promedioVentas,
                            style: {
                                color: '#FF0000',
                                background: '#FFFFFF',
                                fontSize: '14px',
                                fontWeight: 600
                            }
                        }
                    }]
                }
            };

            // Crear e iniciar el gráfico
            var chart = new ApexCharts(document.querySelector("#chart"), options);
            chart.render();  // Renderiza el gráfico

            // Subcategorías más vendidas
            var unidadesVendidas = @json($unidadesVendidas);

            var unidadesOptions = {
                chart: {
                    type: 'bar',
                },
                series: [{
                    name: 'Unidades Vendidas',
                    data: unidadesVendidas.map(item => ({
                        x: item.subcategory,
                        y: item.total
                    }))
                }],
                xaxis: {
                    type: 'category',
                    title: {
                        text: 'Subcategorías'
                    }
                },
                yaxis: {
                    title: {
                        text: 'Unidades Vendidas'
                    }
                },
                colors: ['#1E90FF'],
                title: {
                    text: 'Unidades Vendidas por Subcategoría',
                    align: 'center'
                }
            };

            var unidadesChart = new ApexCharts(document.querySelector("#unidadesChart"), unidadesOptions);
            unidadesChart.render();
        }
</script>

