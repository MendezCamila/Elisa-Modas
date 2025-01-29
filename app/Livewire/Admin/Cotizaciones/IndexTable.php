<?php

namespace App\Livewire\Admin\Cotizaciones;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Cotizacion;
use App\Models\Supplier;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\Views\SearchFilter;
use Illuminate\Database\Eloquent\Builder;

class IndexTable extends DataTableComponent
{
    protected $model = Cotizacion::class;

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
            Column::make("Id", "id")
                ->searchable(),

            Column::make("Fecha creación", "created_at")
                ->format(fn($value) => $value ? $value->format('d/m/Y') : 'N/A'),

            Column::make("Proveedor", "supplier_id")
                ->searchable(function ($builder, $term) {
                    // Búsqueda por nombre o apellido del proveedor
                    $builder->orWhereHas('proveedor', function ($query) use ($term) {
                        $query->where('name', 'like', "%{$term}%")
                            ->orWhere('last_name', 'like', "%{$term}%");
                    });
                })
                ->format(function ($value) {
                    $supplier = Supplier::find($value);
                    return $supplier ? $supplier->name . ' ' . $supplier->last_name : 'N/A';
                }),

            Column::make("Plazo Respuesta")
                ->label(function ($row) {
                    $detalle = $row->detalleCotizaciones->first();
                    // Formatea la fecha del plazo de respuesta si existe
                    return $detalle && $detalle->plazo_resp
                        ? Carbon::parse($detalle->plazo_resp)->format('d/m/Y')
                        : 'N/A';
                }),
            Column::make("Estado", "estado")
                ->searchable()
                ->html()
                ->format(fn($value) => match ($value) {
                    'pendiente' => '<span class="badge bg-warning">Pendiente</span>',
                    'enviada' => '<span class="badge bg-primary">Enviada</span>',
                    'respondida' => '<span class="badge bg-success">Respondida</span>',
                    'no respondida' => '<span class="badge bg-danger">No Respondida</span>',
                    default => '<span class="badge bg-secondary">Desconocido</span>',
                }),


            Column::make("Acciones","id")
                ->label(function ($row) {
                    return view('admin.cotizaciones.actions', ['cotizacion' => $row]);
                }),
        ];
    }

    public function query()
    {
        // Realiza la consulta básica, con la búsqueda si se activa
        return Cotizacion::query()
            ->with('supplier') // Asegúrate de cargar la relación de los proveedores
            ->when($this->search, function ($query) {
                // Filtra por nombre o apellido del proveedor
                $query->whereHas('supplier', function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                });
            });
    }

    public function filters(): array
    {
        return [
            // Filtro por proveedor: Mostrar nombre y apellido del proveedor
            SelectFilter::make('Proveedor', 'supplier_id')
                ->options(
                    Supplier::query()
                        ->distinct()
                        ->get()
                        ->pluck('name', 'id')
                        ->mapWithKeys(function ($name, $id) {
                            $supplier = Supplier::find($id);
                            return [$id => $supplier->name . ' ' . $supplier->last_name];
                        }) // Concatenamos nombre y apellido
                        ->toArray()
                )
                ->filter(function ($query, $value) {
                    return $query->where('supplier_id', $value); // Filtra las cotizaciones por el proveedor seleccionado
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
                    'placeholder' => 'Selecciona un rango de fechas',
                    'locale' => 'es',
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

            // Filtro por estado de la cotización
            SelectFilter::make('Estado', 'estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'enviada' => 'Enviada',
                    'respondida' => 'Respondida',
                    'no respondida' => 'No Respondida',
                ])
                ->filter(function ($query, $value) {
                    return $query->where('estado', $value); // Filtra por el estado seleccionado
                }),
        ];
    }
}
