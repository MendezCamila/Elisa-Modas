<?php

namespace App\Livewire\Admin\PreVentas;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\PreVenta;

class IndexTable extends DataTableComponent
{
    protected $model = PreVenta::class;
    public $cantidadRecibida;
    public $selectedPreVenta = null;
    public $showModal = false;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Variant id", "variant_id")
                ->sortable(),
            Column::make("Cantidad", "cantidad")
                ->sortable(),
            Column::make("Descuento", "descuento")
                ->sortable(),
            Column::make("Fecha inicio", "fecha_inicio")
                ->sortable(),
            Column::make("Fecha fin", "fecha_fin")
                ->sortable(),
            Column::make("Estado", "estado")
                ->sortable(),
            Column::make("Acciones")
                ->label(fn($row) => view('admin.pre-ventas.actions', ['preVenta' => $row])),
        ];
    }


    public function openReceptionModal($preVentaId)
    {
        $this->selectedPreVenta = PreVenta::find($preVentaId);
        $this->cantidadRecibida = null;

        // Establece showModal en true para abrir el modal
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;  // Esto cierra el modal
    }

    public function updateReception()
    {
        $this->validate([
            'cantidadRecibida' => 'required|integer|min:1',
        ]);

        if ($this->selectedPreVenta) {
            $variant = $this->selectedPreVenta->variant;

            if ($variant) {
                // Incrementa el stock
                $variant->increment('stock', $this->cantidadRecibida);

                if ($variant->estado !== 'disponible') {
                    $variant->update(['estado' => 'disponible']);
                }
            }

            $this->selectedPreVenta->update(['estado' => 'disponible']);

            $this->dispatch('swal', [
                'title' => 'Actualización exitosa!',
                'text' => 'La recepción ha sido registrada correctamente.',
                'icon' => 'success'
            ]);

            // Cierra el modal
            $this->closeModal();  // Llamamos al método para cerrar el modal
        }
    }
}

