<?php

namespace App\Livewire\Admin\Cotizaciones;

use Livewire\Component;
use App\Models\Category;
use App\Models\Variant;
use App\Models\Supplier;
use App\Models\Subcategory;
use App\Models\Product;

class CreateCotizacion extends Component
{
    // Agrega esta propiedad para almacenar los IDs de subcategorías seleccionadas
    public $subcategory_ids = [];


    public $subcategories = [];

    // Agrega esta propiedad para almacenar las variantes de los productos
    public $variants = [];


    public $variant_ids = [];  // Agrega esta propiedad para almacenar la variante seleccionada

    public $subcategory_id;

    public $variant_id;

    public function mount()
    {
        //recupero todas las categorias
        $this->categories = Category::all();

        //recupero todas los proveedores
        $this->suppliers = Supplier::all();

        $this->subcategories = Subcategory::with('category.family')->get();


        $this->dispatch('initializeSelect2');
    }

    public function hydrate()
    {
        $this->dispatch('initializeSelect2');
    }

    //creacion reglas de validacion
    protected function rules() {}

    public function updatedSubcategoryIds($value)
    {
        
        $this->subcategory_ids = is_array($value) ? $value : explode(',', $value);
        $this->updateVariants();
    }

    protected function messages()
    {
        return [
            'subcategory_ids.required' => 'Debe seleccionar al menos una subcategoría.',
            'subcategory_ids.min' => 'Debe seleccionar al menos una subcategoría.',
        ];
    }

    public function updateVariants()
{
    /*
    $variantData = []; // Array para almacenar los datos formateados

    if (count($this->subcategory_ids) > 0) {
        $this->variants = Variant::whereHas('product', function ($query) {
            $query->whereIn('subcategory_id', $this->subcategory_ids);
        })
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

            if ($featuresString) {
                $variantData[] = [
                    'id' => $variant->id,
                    'name' => $productName . ' (' . $featuresString . ')'
                ];
            }
        }

        $this->variants = $variantData;
        //dd($this->variants);

    } else {
        $this->variants = [];
    }
        */

        $variantData = []; // Array para almacenar los datos formateados

        if (count($this->subcategory_ids) > 0) {
            $variants = Variant::whereHas('product', function ($query) {
                $query->whereIn('subcategory_id', $this->subcategory_ids);
            })
            ->with('features', 'product') // Cargar características asociadas a las variantes y los productos
            ->get();
    
            foreach ($variants as $variant) {
                $productName = $variant->product->name;
                $variantFeatures = [];
    
                foreach ($variant->features as $feature) {
                    if ($feature->description) {
                        $variantFeatures[] = $feature->description;
                    }
                }
    
                $featuresString = implode(', ', $variantFeatures);
    
                if ($featuresString) {
                    $variantData[] = [
                        'id' => $variant->id,
                        'name' => $productName . ' (' . $featuresString . ')'
                    ];
                }
            }
    
            $this->variants = $variantData; // Asignar las variantes formateadas a la propiedad
            //dd( $this->variants);
            \Log::info('Variants after assignment:', $this->variants);
        } else {
            $this->variants = [];
        }
}





    public function render()
    {
        return view('livewire.admin.cotizaciones.create-cotizacion');
    }
}
