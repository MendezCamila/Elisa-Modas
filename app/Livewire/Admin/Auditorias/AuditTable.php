<?php

namespace App\Livewire\Admin\Auditorias;

use Livewire\Component;
use Livewire\WithPagination;
use OwenIt\Auditing\Models\Audit;
use Illuminate\Support\Facades\Auth;
//model user
use App\Models\User;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\Views\Filters\TextFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\NumberRangeFilter;
use Rappasoft\LaravelLivewireTables\Views\Filters\DateRangeFilter;



class AuditTable extends DataTableComponent
{
    use WithPagination;
    //usar el modelo de la auditoria
    protected $model = Audit::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('created_at', 'desc'); // Ordenar por fecha
        $this->setPaginationEnabled();
        $this->setSortingPillsEnabled();

        $this->setSearchVisibilityStatus(true);
        $this->setSearchVisibilityEnabled();
        //$this->setSearchDisabled();
    }

    public function columns(): array
    {
        return [
            Column::make('ID', 'id')
                ->searchable()
                ->collapseOnTablet(),

            Column::make('Nombre y Apellido', 'user_id')
                ->format(function ($value, $row) {
                    // Buscamos el usuario por su ID y concatenamos name y last_name
                    $user = \App\Models\User::find($value);
                    return $user
                        ? htmlspecialchars($user->name . ' ' . $user->last_name, ENT_QUOTES, 'UTF-8')
                        : 'Usuario no encontrado';
                })
                ->searchable(function ($builder, $term) {
                    // Buscamos en la relación "user" en los campos "name" y "last_name"
                    $builder->orWhereHas('user', function ($query) use ($term) {
                        $query->where('name', 'like', "%{$term}%")
                            ->orWhere('last_name', 'like', "%{$term}%");
                    });
                }),





            Column::make('Modelo', 'auditable_type'),

            Column::make('Evento', 'event')->searchable(),

            Column::make('Valores Nuevos', 'new_values')
                ->format(function ($value) {
                    if (empty($value)) {
                        return 'Sin valores'; // Si no hay valores nuevos, mostramos 'Sin valores'
                    }

                    $decoded = is_array($value) ? $value : json_decode($value, true); // Verificar tipo de dato
                    if (is_array($decoded)) {
                        // Excluir los campos que no deseas mostrar
                        $filtered = collect($decoded)->except([
                            'password',
                            'email_verified_at',
                            'two_factor_secret',
                            'two_factor_recovery_codes',
                            'two_factor_confirmed_at',
                            'remember_token',
                            'current_team_id',
                            'profile_photo_path'
                        ]);
                        return '<ul>' . $filtered->map(function ($val, $key) {
                            return "<li><strong>" . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . ":</strong> " . htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . "</li>";
                        })->join('') . '</ul>';
                    }
                    return 'Sin datos';
                })
                ->html(), // Permite contenido HTML en la columna

            Column::make('Valores Antiguos', 'old_values')
                ->format(function ($value) {
                    if (empty($value)) {
                        return 'Sin valores'; // Si no hay valores antiguos, mostramos 'Sin valores'
                    }

                    // Decodificar valores o verificar si están vacíos
                    $decoded = is_array($value) ? $value : json_decode($value, true);
                    if (empty($decoded)) {
                        return 'Sin valores'; // Mostrar mensaje si no hay valores
                    }
                    // Excluir los campos que no deseas mostrar
                    $filtered = collect($decoded)->except([
                        'password',
                        'email_verified_at',
                        'two_factor_secret',
                        'two_factor_recovery_codes',
                        'two_factor_confirmed_at',
                        'remember_token',
                        'current_team_id',
                        'profile_photo_path'
                    ]);
                    return '<ul>' . $filtered->map(function ($val, $key) {
                        return "<li><strong>" . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . ":</strong> " . htmlspecialchars($val, ENT_QUOTES, 'UTF-8') . "</li>";
                    })->join('') . '</ul>';
                })
                ->html(),
            Column::make('Fecha', 'created_at')
                ->format(function ($value) {
                    // Formatear la fecha en el formato día/mes/año
                    return \Carbon\Carbon::parse($value)->format('j/n/Y');
                }),

        ];
    }

    public function query()
    {
        return Audit::query()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->orWhereHas('user', function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('last_name', 'like', "%{$this->search}%");
                });
            });
    }

    public function filters(): array
    {
        return [


            // Filtro por Evento
            SelectFilter::make('Evento', 'event')
                ->options(Audit::select('event')->distinct()->pluck('event', 'event')->toArray())
                ->filter(function ($query, $value) {
                    if ($value) {
                        $query->where('event', $value);
                    }
                }),

            // Filtro por Modelo
            SelectFilter::make('Modelo', 'auditable_type')
                ->options(Audit::select('auditable_type')->distinct()->pluck('auditable_type', 'auditable_type')->toArray())
                ->filter(function ($query, $value) {
                    if ($value) {
                        $query->where('auditable_type', $value);
                    }
                }),

            // Filtro por rango de fechas
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
        ];
    }








    public function rowView(): string
    {
        return 'livewire-tables.rows.audit_table';
    }
}
