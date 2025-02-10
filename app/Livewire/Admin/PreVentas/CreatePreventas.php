<?php

namespace App\Livewire\Admin\PreVentas;

use Livewire\Component;
use App\Models\preVenta;
use App\Models\Variant;
use Carbon\Carbon;

class CreatePreventas extends Component
{
    public $variant_id;
    public $pool;
    public $descuento;
    public $start_date;
    public $end_date;
    public $variants = [];

    protected $rules = [
        'variant_id' => 'required|exists:variants,id',
        'pool' => 'required|integer|min:1',
        'descuento' => 'required|integer|min:1|max:100',
        'start_date' => 'required|date|after_or_equal:today',
        'end_date' => 'required|date|after:start_date',
    ];

    public function mount(){

        $this->updateVariants();
        $this->dispatch('initializeSelect2');
    }

    public function hydrate()
    {
        $this->dispatch('initializeSelect2');
    }

    public function updateVariants()
    {
        $variantData = []; // Array para almacenar los datos formateados

        $this->variants = Variant::where('estado', 'preventa')
            ->where('stock', 0)
            ->with('features', 'product') // Cargar características asociadas a las variantes y los productos
            ->get();

        foreach ($this->variants as $variant) {
            $productName = $variant->product->name;
            $variantFeatures = [];

            foreach ($variant->features as $feature) {
                if ($feature->description) {
                    $variantFeatures[] = $feature->description;
                }
            }

            $featuresString = implode(', ', $variantFeatures);

            $variantData[] = [
                'id' => $variant->id,
                'name' => $productName . ($featuresString ? ' (' . $featuresString . ')' : '')
            ];
        }

        $this->variants = $variantData;
    }

    public function submit(){

        $this->validate();

        PreVenta::create([
            'variant_id' => $this->variant_id,
            'cantidad' => $this->pool,
            'descuento' => $this->descuento,
            'fecha_inicio' => Carbon::parse($this->start_date),
            'fecha_fin' => Carbon::parse($this->end_date),
            'estado' => 'preventa',
        ]);


        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'La preventa ha sido creada correctamente',
        ]);

        return redirect()->route('admin.pre-ventas.index');
    }



    public function boot()
    {
        $this->withValidator(function ($validator) {
            // Verificar si hay errores de validación
            if ($validator->fails()) {
                // Disparar una alerta con los detalles del error
                $this->dispatch('swal', [
                    'icon' => 'error',
                    'title' => 'Error!',
                    'text' => 'El formulario contiene errores.',
                ]);
            }
        });
    }

    public function render()
    {
        $variants = Variant::where('estado', 'preventa')
            ->where('stock', 0)
            ->get();
        return view('livewire.admin.pre-ventas.create-preventas', compact('variants'));
    }
}
