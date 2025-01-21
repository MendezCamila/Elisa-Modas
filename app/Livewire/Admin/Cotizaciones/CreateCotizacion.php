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
    public $subcategory_ids = []; // Agrega esta propiedad para almacenar los IDs de subcategorías seleccionadas
    public $subcategories = [];

    // Agrega esta propiedad para almacenar las variantes
    public $variants = [];
    public $variant_id; // Agrega esta propiedad para almacenar la variante seleccionada

    public $subcategory_id;

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

    $variantData = []; // Array para almacenar los datos formateados

    // Asegúrate de que subcategory_ids esté definido y no esté vacío
    if (count($this->subcategory_ids) > 0) {
        // Obtener las variantes de los productos asociados a las subcategorías seleccionadas
        $this->variants = Variant::whereHas('product', function ($query) {
            $query->whereIn('subcategory_id', $this->subcategory_ids);
        })
        ->with('features', 'product') // Cargar características asociadas a las variantes y los productos
        ->get();

        // Iterar sobre las variantes obtenidas
        foreach ($this->variants as $variant) {
            // Obtener el nombre del producto
            $productName = $variant->product->name;

            // Inicializar un array para las características de la variante
            $variantFeatures = [];

            // Iterar sobre las características de la variante
            foreach ($variant->features as $feature) {
                // Verificar si la descripción existe y agregarla entre paréntesis
                if ($feature->description) {
                    $variantFeatures[] = $feature->description; // Solo agregar la descripción
                }
            }

            // Unir las características con coma y espacio
            $featuresString = implode(', ', $variantFeatures);

            // Formatear el nombre del producto con las características de la variante
            if ($featuresString) {
                $variantData[] = $productName . ' (' . $featuresString . ')'; // Mostrar solo descripciones
            }
        }

        // Depurar los datos obtenidos (solo para revisar el resultado)
        dd($variantData);

    } else {
        $this->variants = []; // Si no hay subcategorías seleccionadas, no se obtienen variantes
    }


}





    public function render()
    {
        return view('livewire.admin.cotizaciones.create-cotizacion');
    }
}
