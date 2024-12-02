<?php

namespace App\Livewire\Admin\Ventas;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use App\Models\Ventas;
use Illuminate\Support\Facades\Storage;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
//clase para la busqueda
use Rappasoft\LaravelLivewireTables\Views\SearchFilter;

class VentaTable extends DataTableComponent
{
    protected $model = Ventas::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        // Ordenar por fecha de creación en orden descendente
        $this->setDefaultSort('created_at', 'desc');

        $this->setPaginationEnabled(); // Habilitar paginación
        $this->setSortingPillsEnabled(); // Habilitar ordenamiento


        $this->setSearchVisibilityStatus(true);
        $this->setSearchVisibilityEnabled();

        //$this->setSearchEnabled();
        //$this->setSearchEnabled();  // Habilita la búsqueda
        //$this->setSearchVisibilityEnabled();  // Muestra el cuadro de búsqueda
        $this->setSearchPlaceholder('Buscar');  // Cambia el placeholder
        //$this->setSearchLive();  // Realiza la búsqueda de inmediato

        $this->setSearchDisabled();


        $this->setEmptyMessage('No se encontraron resultados'); // Mensaje de tabla vacía
    }

    public function columns(): array
    {
        return [
            //Nº venta
            Column::make("Nº venta", "id")
                ->sortable(),

            //Fecha de venta
            Column::make("F. venta", "created_at")
                ->format(function($value){
                    return $value->format('d/m/Y');
                })
                ->sortable(),

            //Usuario que realizó la compra
            Column::make("id cliente", "user_id")
                ->sortable(),

             // Columna "User ID" que muestra el nombre del usuario
            Column::make("Cliente", "user.name")
                ->label(function($row){
                return $row->user ? $row->user->name . ' ' . $row->user->last_name : 'No asignado';
            })
            ->sortable(),

            //Nº de operación (payment_id)
            Column::make("Nº de operación", "payment_id")
                ->sortable(),

            //Total de la venta
            Column::make("Total", "total")
                ->format(function($value){
                    return "$".number_format($value, 2);
                })
                ->sortable(),

            Column::make("Comprobante")
                ->label(function($row){
                    return view('admin.ventas.comprobante', ['venta' => $row]);
                })
        ];
    }

    public function filters(): array
{
    //dd(request()->query('table-search'));

    return [
        //Filtro busqueda
        // Filtro por búsqueda en múltiples campos
        TextFilter::make('Buscar')
        ->filter(function ($query, $value) {

        //dd($query->toSql(), $query->getBindings());

        // Asegúrate de que el valor del filtro esté siendo utilizado en la consulta correctamente
        $query->where(function ($query) use ($value) {
            $query->where('id', 'like', "%$value%")
                ->orWhereHas('user', function ($query) use ($value) {
                    $query->where('name', 'like', "%$value%")
                        ->orWhere('last_name', 'like', "%$value%");
                })
                ->orWhere('payment_id', 'like', "%$value%");
        });
    }),

        // Filtro por cliente (id cliente)
        SelectFilter::make('ID Cliente', 'user_id')
            ->options(
                Ventas::query()
                    ->distinct()
                    ->get()
                    ->pluck('user_id', 'user_id')
                    ->toArray()
            )
            ->filter(function ($query, $value) {
                return $query->where('user_id', $value);
            }),

        // Filtro por fecha de venta
        DateRangeFilter::make('Rango de Fechas')
            ->config([
                'allowInput' => true, // Permitir entrada manual de fechas
                'altFormat' => 'd F, Y', // Formato que se muestra al usuario
                'ariaDateFormat' => 'd F, Y', // Formato para lectores de pantalla
                'dateFormat' => 'Y-m-d', // Formato usado en la base de datos
                'earliestDate' => '2020-01-01', // Fecha más temprana permitida
                'latestDate' => '2030-12-31', // Fecha más reciente permitida
                'placeholder' => 'Selecciona un rango de fechas', // Texto de marcador de posición
                'locale' => 'es', // Idioma en español
            ])
            ->filter(function ($query, array $dateRange) {
                $minDate = $dateRange['minDate'] ?? null; // Fecha mínima seleccionada
                $maxDate = $dateRange['maxDate'] ?? null; // Fecha máxima seleccionada

                if ($minDate) {
                    $query->whereDate('created_at', '>=', $minDate); // Filtra desde la fecha mínima
                }

                if ($maxDate) {
                    $query->whereDate('created_at', '<=', $maxDate); // Filtra hasta la fecha máxima
                }
            }),

        // Filtro por rango de precio
        NumberRangeFilter::make('Rango de Precio')
            ->options([
                'min' => 0, // Valor mínimo permitido en el rango
                'max' => 50000, // Valor máximo permitido en el rango
            ])
            ->config([
                'minRange' => 0,
                'maxRange' => 50000, // Máximo del rango
                'prefix' => '$', // Prefijo para mostrar antes del número
            ])
            ->filter(function ($query, array $values) {
                $min = isset($values['min']) ? (float)$values['min'] : 0;
                $max = isset($values['max']) ? (float)$values['max'] : 50000;

                $query->whereBetween('total', [$min, $max]);
            }),

    ];


}

    public function descargarComprobante(Ventas $venta)
    {
        //dd($venta);
        return Storage::download($venta->pdf_path);
    }

}
