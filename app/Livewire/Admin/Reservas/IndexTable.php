<?php

namespace App\Livewire\Admin\Reservas;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Reserva;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;
use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\Views\SearchFilter;
use Illuminate\Database\Eloquent\Builder;

class IndexTable extends DataTableComponent
{
    protected $model = Reserva::class;

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
            // Columna ID de la reserva
            Column::make("Id", "id")
                ->searchable(),

            // Columna para mostrar el nombre y apellido del usuario
            Column::make("Usuario", "user_id")
                ->searchable(function ($builder, $term) {
                    $builder->orWhereHas('user', function ($query) use ($term) {
                        $query->where('name', 'like', "%{$term}%")
                            ->orWhere('last_name', 'like', "%{$term}%");
                    });
                })
                ->format(function ($value, $row) {
                    return $row->user
                        ? $row->user->name . ' ' . $row->user->last_name
                        : 'N/A';
                }),

            // Columna para la fecha de creación (con formato)
            Column::make("Fecha Creación", "created_at")
                ->searchable()
                ->format(fn($value) => $value ? $value->format('d/m/Y') : 'N/A'),

            // Columna para el estado, con formato en badge
            Column::make("Estado", "estado")
                ->searchable()
                ->html()
                ->format(fn($value) => match ($value) {
                    'pagado'   => '<span class="badge bg-success">Pagado</span>',
                    'pendiente' => '<span class="badge bg-warning">Pendiente</span>',
                    default    => '<span class="badge bg-secondary">Desconocido</span>',
                }),

            // Nueva columna para acciones
            Column::make("Acciones", "id")
                ->label(function ($row) {
                    // Si la reserva está pendiente, se muestra el botón para confirmar el pago.
                    if ($row->estado === 'pendiente') {
                        return '<button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded shadow transition-colors duration-200" wire:click="confirmarPago(' . $row->id . ')">Confirmar Pago</button>';
                    }
                    return '';
                })
                ->html(),
        ];
    }

    public function query()
    {
        $search = $this->search;

        return Reserva::query()
            ->with('user')
            ->when($search, function ($query) use ($search) {
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
        return [
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

            // Filtro por estado: Pagada o Pendiente
            SelectFilter::make('Estado', 'estado')
                ->options([
                    'pagada'    => 'Pagada',
                    'pendiente' => 'Pendiente',
                ])
                ->filter(function ($query, $value) {
                    return $query->where('estado', $value);
                }),
        ];
    }

    public function confirmarPago($reservaId)
    {
        // Buscar la reserva por su ID
        $reserva = \App\Models\Reserva::find($reservaId);

        // Verificamos que exista y que esté en estado "pendiente"
        if ($reserva && $reserva->estado === 'pendiente') {
            $reserva->update(['estado' => 'pagado']);

            // Opcional: si se desea, descontar del stock de la variante (por ejemplo, ya que el pago se ha confirmado)
            $reserva->preVenta->variant->decrement('stock', $reserva->cantidad);

            session()->dispatch('swal', [
                'icon' => 'success',
                'title' => 'Pago confirmado',
                'text' => 'La reserva ha sido marcada como pagada.',
            ]);
        }
    }
}
