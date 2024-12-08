<!-- Incluye la biblioteca de ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
        <!-- Ventas -->
        <div class="bg-white rounded-lg shadow-lg p-6 mt-6">
            <h3 class="text-lg font-semibold">Ventas</h3>
            <div id="chart" style="height: 400px;"></div>
        </div>

        <!-- Productos más vendidos -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold">Productos más vendidos</h3>
            <ul>

            </ul>
        </div>

        <!-- Productos con stock bajo
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-lg font-semibold">Stock bajo</h3>
            <ul>

            </ul>
        </div>-->
    </div>


</x-admin-layout>

<script>
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
    }
</script>


