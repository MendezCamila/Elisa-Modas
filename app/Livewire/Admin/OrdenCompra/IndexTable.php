<?php

namespace App\Livewire\Admin\OrdenCompra;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\OrdenCompra;
use App\Models\Supplier;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\Views\SearchFilter;
use Illuminate\Database\Eloquent\Builder;


class IndexTable extends DataTableComponent
{
    protected $model = OrdenCompra::class;

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
        $this->setSearchEnabled();  // Habilita la búsqueda
        //$this->setSearchVisibilityEnabled();  // Muestra el cuadro de búsqueda
        $this->setSearchPlaceholder('Buscar');  // Cambia el placeholder
        //$this->setSearchLive();  // Realiza la búsqueda de inmediato

        //$this->setSearchDisabled();


        $this->setEmptyMessage('No se encontraron resultados'); // Mensaje de tabla vacía
    }

    public function query(): Builder
    {
        // Incluye relaciones necesarias para los filtros y columnas
        return OrdenCompra::query()
            ->with(['detalleOrdenCompras.variant.product', 'proveedor']);
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ,
            Column::make("Proveedor", "supplier_id")
                ->searchable(function ($builder, $term) {
                    // Búsqueda por nombre o apellido del proveedor
                    $builder->orWhereHas('proveedor', function ($query) use ($term) {
                        $query->where('name', 'like', "%{$term}%")
                            ->orWhere('last_name', 'like', "%{$term}%");
                    });
                })
                ->format(function ($value, $row) {
                    $supplier = $row->proveedor;
                    return $supplier ? $supplier->name . ' ' . $supplier->last_name : 'N/A';
                }),
            Column::make("Fecha de Creación", "created_at")
                ->format(function ($value) {
                    return $value->format('d/m/Y');
                }),
            Column::make("Acciones", "id")
                ->label(function ($row) {
                    return view('admin.orden-compras.actions', ['ordenCompra' => $row]);
                }),
        ];
    }

    public function filters(): array
    {
        return [
            // Filtro por proveedor
            SelectFilter::make('Proveedor', 'supplier_id')
                ->options(
                    Supplier::query()
                        ->distinct()
                        ->get()
                        ->pluck('name', 'id') // Obtenemos el 'name' y 'id' de los proveedores
                        ->mapWithKeys(function ($name, $id) {
                            // Concatenamos nombre y apellido utilizando el 'id'
                            $supplier = Supplier::find($id);
                            return [$id => $supplier ? $supplier->name . ' ' . $supplier->last_name : 'Proveedor no encontrado'];
                        })
                        ->toArray()
                )
                ->filter(function ($query, $value) {
                    return $query->where('supplier_id', $value); // Filtra las ordenes de compra por el proveedor seleccionado
                }),

            // Filtro por rango de fechas de creación
            DateRangeFilter::make('Rango de Fechas')
                ->config([
                    'allowInput' => true,
                    'altFormat' => 'd F, Y',
                    'ariaDateFormat' => 'd F, Y',
                    'dateFormat' => 'Y-m-d',
                    'earliestDate' => '2020-01-01',
                    'latestDate' => '2030-12-31',
                    'locale' => 'es',
                    'placeholder' => 'Selecciona un rango de fechas',
                ])
                ->filter(function ($query, array $dateRange) {
                    $minDate = $dateRange['minDate'] ?? null;
                    $maxDate = $dateRange['maxDate'] ?? null;

                    if ($minDate) {
                        $query->whereDate('created_at', '>=', $minDate);
                    }

                    if ($maxDate) {
                        $query->whereDate('created_at', '<=', $maxDate);
                    }
                }),
        ];
    }
}
