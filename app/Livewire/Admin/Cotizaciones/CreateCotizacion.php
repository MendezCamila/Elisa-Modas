<?php

namespace App\Livewire\Admin\Cotizaciones;

use Livewire\Component;
use App\Models\Category;
use App\Models\Variant;
use App\Models\Supplier;
use App\Models\Subcategory;

class CreateCotizacion extends Component
{
    public $subcategory_ids = []; // Agrega esta propiedad para almacenar los IDs de subcategorías seleccionadas
    public $subcategories = [];

    // Agrega esta propiedad para almacenar las variantes
    public $variants = [];
    public $variant_id ;// Agrega esta propiedad para almacenar la variante seleccionada

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
    protected function rules()
    {

    }

    public function updatedSubcategoryIds($value)
    {
        /* Actualizar los IDs de subcategorías cuando cambian
        $this->subcategory_ids = $value;
        $this->updateVariants();*/
        // Asegúrate de que $value sea un array
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
        if (count($this->subcategory_ids) > 0) {
            $this->variants = Variant::whereIn('product_id', function($query) {
                $query->select('id')
                    ->from('products')
                    ->whereIn('subcategory_id', $this->subcategory_ids);
            })->get();
        } else {
            $this->variants = [];
        }
    }

    public function render()
    {
        return view('livewire.admin.cotizaciones.create-cotizacion');
    }
}
