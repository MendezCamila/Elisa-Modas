<?php

namespace App\Livewire\Admin\Cotizaciones;

use Livewire\Component;
use App\Models\Supplier;

class ManageCotizaciones extends Component
{
    //cargo todos los proveedores
    public $suppliers;

    public function mount()
    {
        $this->suppliers = Supplier::all();
    }

    public function render()
    {
        return view('livewire.admin.cotizaciones.manage-cotizaciones', [
            'suppliers' => $this->suppliers,
        ]);
    }
}
