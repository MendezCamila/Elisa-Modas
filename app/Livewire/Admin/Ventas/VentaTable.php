<?php

namespace App\Livewire\Admin\Ventas;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use App\Models\Ventas;

use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\SearchFilter;

//pdf
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;


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
            // Nº venta
            Column::make("Nº venta", "id")
                ->searchable(),

            // Fecha de venta
            Column::make("F. venta", "created_at")
                ->format(function ($value) {
                    return $value->format('d/m/Y');
                }),

            // ID Cliente (opcional, se muestra internamente)
            Column::make("id cliente", "user_id")
                ->searchable(),

            // Cliente: muestra nombre y apellido del usuario
            // Cliente: muestra nombre y apellido del usuario
            Column::make("Cliente", "user_id")
                ->searchable(function ($builder, $term) {
                    // Búsqueda por nombre o apellido del cliente
                    $builder->orWhereHas('user', function ($query) use ($term) {
                        $query->where('name', 'like', "%{$term}%")
                            ->orWhere('last_name', 'like', "%{$term}%");
                    });
                })
                ->format(function ($value, $row) {
                    return $row->user
                        ? $row->user->name . ' ' . $row->user->last_name
                        : 'No asignado';
                }),

            // Nº de operación (payment_id)
            Column::make("Nº de operación", "payment_id")
                ->searchable(),

            // Total de la venta
            Column::make("Total", "total")
                ->format(function ($value) {
                    return "$" . number_format($value, 2);
                }),



            Column::make("Estado", "estado")
                ->searchable()
                ->html()
                ->format(fn($value) => match ($value) {
                    'pagada'   => '<span class="badge bg-success">Pagada</span>',
                    'pendiente' => '<span class="badge bg-warning">Pendiente</span>',
                    'entregado' => '<span class="badge bg-info">Entregado</span>',
                    default    => '<span class="badge bg-secondary">Desconocido</span>',
                }),

            // Acciones: Botón para marcar como entregado (solo si está pendiente)
            Column::make("Acciones", "id")
                ->label(function ($row) {
                    if ($row->estado === 'pendiente') {
                        return '<button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow transition duration-200" wire:click="cambiarEstado(' . $row->id . ')">Marcar como entregado</button>';
                    }
                    return '<span class="text-sm text-gray-600">Entregado</span>';
                })
                ->html(),

            // Comprobante
            Column::make("Comprobante")
                ->label(function ($row) {
                    return view('admin.ventas.comprobante', ['venta' => $row]);
                }),
        ];
    }

    public function query(): Builder
    {
        $search = $this->search;

        return Ventas::query()
            ->with('user')
            ->when($search, function (Builder $query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('id', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            });
    }

    public function filters(): array
    {
        // Calculamos las opciones de clientes una sola vez
        $clientesOptions = Ventas::query()
            ->with('user')
            ->get()
            ->unique('user_id')
            ->mapWithKeys(function ($venta) {
                return [
                    $venta->user_id => $venta->user
                        ? $venta->user->name . ' ' . $venta->user->last_name
                        : 'Sin nombre'
                ];
            })->toArray();

        return [
            // Filtro por Cliente (Nombre y Apellido)
            SelectFilter::make('Cliente', 'user_id')
                ->options($clientesOptions)
                ->filter(function ($query, $value) {
                    return $query->where('user_id', $value);
                }),

            // Filtro por rango de fechas (para la columna created_at)
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
                        $query->whereDate('created_at', '>=', $minDate);
                    }
                    if ($maxDate) {
                        $query->whereDate('created_at', '<=', $maxDate);
                    }
                }),

            // Filtro por estado
            SelectFilter::make('Estado', 'estado')
                ->options([
                    'pendiente' => 'Pendiente',
                    'entregado' => 'Entregado',
                ])
                ->filter(function ($query, $value) {
                    return $query->where('estado', $value);
                }),

            // Filtro por rango de precio
            NumberRangeFilter::make('Rango de Precio')
                ->options([
                    'min' => 0,
                    'max' => 50000,
                ])
                ->config([
                    'minRange' => 0,
                    'maxRange' => 50000,
                    'prefix' => '$',
                ])
                ->filter(function ($query, array $values) {
                    $min = isset($values['min']) ? (float)$values['min'] : 0;
                    $max = isset($values['max']) ? (float)$values['max'] : 50000;
                    $query->whereBetween('total', [$min, $max]);
                }),
        ];
    }

    public function cambiarEstado($ventaId)
    {
        $venta = \App\Models\Ventas::find($ventaId);
        if ($venta && $venta->estado === 'pendiente') {
            $venta->estado = 'entregado';
            $venta->save();

            session()->flash('message', 'El estado de la venta ha sido actualizado a "entregado".');
        }
    }


    public function descargarComprobante(Ventas $venta)
    {
        //dd($venta);
        return Storage::download($venta->pdf_path);
    }
}
