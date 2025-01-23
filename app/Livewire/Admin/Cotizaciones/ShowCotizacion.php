<?php

namespace App\Livewire\Admin\Cotizaciones;

use Livewire\Component;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;

class ShowCotizacion extends Component
{

    public $cotizacion; //Cotizacion cargada

    public function mount($id)
    {
        $this->cotizacion = Cotizacion::with('detalleCotizaciones.variant')->findOrFail($id);
    }

    public function render()
    {
        return view('livewire.admin.cotizaciones.show-cotizacion', [
            'cotizacion' => $this->cotizacion
        ]);
    }
}
