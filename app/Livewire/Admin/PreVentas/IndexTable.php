<?php

namespace App\Livewire\Admin\PreVentas;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PreVenta;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\Views\SearchFilter;
use Illuminate\Database\Eloquent\Builder;

class IndexTable extends DataTableComponent
{
    protected $model = PreVenta::class;


    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setTableAttributes([
            'class' => 'table table-striped table-bordered',
        ]);

        // Ordenar por fecha de creación en orden descendente
        $this->setDefaultSort('created_at', 'desc');

        $this->setPaginationEnabled(); // Habilitar paginación
        $this->setSortingPillsEnabled(); // Habilitar ordenamiento


        $this->setSearchVisibilityStatus(true);
        $this->setSearchVisibilityEnabled();

        //$this->setSearchEnabled();
        $this->setSearchEnabled();  // Habilita la búsqueda
        //$this->setSearchVisibilityEnabled();  // Muestra el cuadro de búsqueda
        $this->setSearchPlaceholder('Buscar');  // Cambia el placeholder
        //$this->setSearchLive();  // Realiza la búsqueda de inmediato

        //$this->setSearchDisabled();


        $this->setEmptyMessage('No se encontraron resultados'); // Mensaje de tabla vacía
    }


    public function columns(): array
    {
        return [
            // Columna: Id de preventa (buscable)
            Column::make("Id", "id")
                ->searchable(),

            // Columna: Producto (se muestra a partir de la relación variant.product)
            Column::make("Producto", "variant_id")
                ->searchable(function ($builder, $term) {
                    $builder->orWhereHas('variant.product', function ($query) use ($term) {
                        $query->where('name', 'like', "%{$term}%");
                    });
                })
                ->format(function ($value, $row) {
                    return $row->variant && $row->variant->product
                        ? $row->variant->product->name
                        : 'N/A';
                }),

            // Columna: Cantidad con sufijo de "unidades"
            Column::make("Cantidad", "cantidad")
                ->format(function ($value) {
                    return $value . ' unidades';
                }),

            // Columna: Descuento con el símbolo de porcentaje
            Column::make("Descuento", "descuento")
                ->format(function ($value) {
                    return $value . '%';
                }),

            // Columna: Fecha inicio con formato d/m/Y
            Column::make("Fecha inicio", "fecha_inicio")
                ->format(fn($value) => $value ? Carbon::parse($value)->format('d/m/Y') : 'N/A'),

            // Columna: Fecha fin con formato d/m/Y
            Column::make("Fecha fin", "fecha_fin")
                ->format(fn($value) => $value ? Carbon::parse($value)->format('d/m/Y') : 'N/A'),

            // Columna: Estado (buscable)
            Column::make("Estado", "estado")
                ->searchable(),

            // Columna: Acciones (usando una vista para renderizar botones, etc.)
            Column::make("Acciones")
                ->label(fn($row) => view('admin.pre-ventas.actions', ['preVenta' => $row])),
        ];
    }

    public function query()
    {
        $search = $this->search;

        return PreVenta::query()
            ->with('variant.product')
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('id', 'like', "%{$search}%")
                          ->orWhere('estado', 'like', "%{$search}%")
                          ->orWhereHas('variant.product', function ($query) use ($search) {
                              $query->where('name', 'like', "%{$search}%");
                          });
                });
            });
    }

    public function filters(): array
    {
        return [
            // Filtro por rango de fechas en "fecha_inicio"
            DateRangeFilter::make('Rango de Fechas')
                ->config([
                    'allowInput'     => true,
                    'altFormat'      => 'd F, Y',
                    'ariaDateFormat' => 'd F, Y',
                    'dateFormat'     => 'Y-m-d',
                    'earliestDate'   => '2020-01-01',
                    'latestDate'     => '2030-12-31',
                    'placeholder'    => 'Selecciona un rango de fechas',
                    'locale'         => 'es',
                ])
                ->filter(function ($query, array $dateRange) {
                    $minDate = $dateRange['minDate'] ?? null;
                    $maxDate = $dateRange['maxDate'] ?? null;

                    if ($minDate) {
                        $query->whereDate('fecha_inicio', '>=', $minDate);
                    }
                    if ($maxDate) {
                        $query->whereDate('fecha_inicio', '<=', $maxDate);
                    }
                }),

            // Filtro por estado: activo o disponible
            SelectFilter::make('Estado', 'estado')
                ->options([
                    'activo'     => 'Activo',
                    'disponible' => 'Disponible',
                ])
                ->filter(function ($query, $value) {
                    $query->where('estado', $value);
                }),
        ];
    }

}

