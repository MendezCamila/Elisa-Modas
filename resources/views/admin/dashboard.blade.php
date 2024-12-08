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
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-lg font-semibold">Ventas</h3>
            <div id="chart"></div> <!-- Contenedor del gráfico -->
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Obtener las ventas desde PHP y pasarlas a JS
        var ventas = @json($ventas); // Esto convierte los datos de ventas en formato JS

        // Extraer los días y los totales de ventas
        var days = ventas.map(function(venta) {
            return venta.day; // Día de la venta
        });

        var totals = ventas.map(function(venta) {
            return venta.total; // Total de la venta
        });

        // Configurar el gráfico
        var options = {
            chart: {
                type: 'line'
            },
            series: [{
                name: 'Ventas',
                data: totals // Datos de ventas
            }],
            xaxis: {
                categories: days, // Días del mes
                title: {
                    text: 'Días del Mes' // Título del eje X
                }
            },
            yaxis: {
                title: {
                    text: 'Total de Ventas (en $)' // Título del eje Y
                }
            },
            title: {
                text: 'Ventas Diarias del Mes', // Título principal del gráfico
                align: 'center',
                margin: 20, // Espacio entre el título y el gráfico
                offsetY: 20 // Ajuste adicional para mover el título hacia abajo
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return "$" + val.toFixed(2); // Formato para el valor de las ventas
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    });
</script>


