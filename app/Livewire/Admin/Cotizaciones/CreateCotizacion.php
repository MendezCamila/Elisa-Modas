<?php

namespace App\Livewire\Admin\Cotizaciones;
//use illuminate\Support\Facades\Mail;



use Livewire\Component;
use App\Models\Category;
use App\Models\Variant;
use App\Models\Supplier;
use App\Models\Subcategory;
use App\Models\Product;
use App\Models\Cotizacion;
use App\Models\DetalleCotizacion;
use App\Mail\EnviarCotizacionMail;
use Illuminate\Support\Facades\Mail;

class CreateCotizacion extends Component
{
    // Agrega esta propiedad para almacenar los IDs de subcategorías seleccionadas
    public $subcategory_ids;


    public $subcategories = [];

    // Agrega esta propiedad para almacenar las variantes de los productos
    public $variants = [];


    public $variant_ids = [];  // Agrega esta propiedad para almacenar la variante seleccionada

    public $variant_id;

    //lista los proveedores asociados a la subcategoria
    public $suppliers = [];
    public $supplier_ids = [];

    public $quantities = [];

    public $plazo_resp;

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

        // Limpiar las selecciones de variantes, cantidades y proveedores
        $this->variant_ids = [];
        $this->quantities = [];
        $this->supplier_ids = [];

        $this->updateVariants();
        $this->updateProveedores();
        $this->dispatch('initializeSelect2');
    }

    public function updatedVariantIds($value)
    {
        $this->variant_ids = is_array($value) ? $value : explode(',', $value);


        foreach ($this->variant_ids as $variant_id) {
            if (!isset($this->quantities[$variant_id])) {
                $this->quantities[$variant_id] = 1; // Inicializa las cantidades con 1 si no está definida
            }
        }
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
    }

    //filtre proveedores en base a la subcategoria selecccioanda
    public function updateProveedores()
    {
        if (count($this->subcategory_ids) > 0) {
            $this->suppliers = Supplier::whereHas('subcategories', function ($query) {
                    $query->whereIn('subcategory_id', $this->subcategory_ids);
                })
                ->where('estado', 'activo') // Filtrar solo proveedores activos
                ->get();
        } else {
            $this->suppliers = [];
        }

        //dd($this->suppliers)->toArray();
    }

    public function enviarCotizacion()
    {

        $this->validate([
            'supplier_ids' => 'required|array|min:1',
            'supplier_ids.*' => 'required|integer|exists:suppliers,id',
            'quantities' => 'required|array|min:1',
            'quantities.*' => 'required|integer|min:1', // Cantidad solicitada por variante
            'plazo_resp' => 'required|date|after:today', // Fecha de plazo de respuesta
            'variant_ids' => 'required|array|min:1', // Variantes seleccionadas
            'supplier_ids' => 'required|array|min:1', // Proveedores seleccionados
        ]);

        foreach ($this->supplier_ids as $supplierId) {
            // Crear la cotización
            $cotizacion = Cotizacion::create([
                'supplier_id' => $supplierId,
                'orden_compra_id' => null, // Inicialmente nulo
                'estado' => 'enviada', // Estado inicial al crear la cotización
            ]);

            foreach ($this->variant_ids as $variantId) {
                DetalleCotizacion::create([
                    'cotizacion_id' => $cotizacion->id,
                    'variant_id' => $variantId,
                    'cantidad_solicitada' => $this->quantities[$variantId], // Cantidad ingresada
                    'plazo_resp' => $this->plazo_resp, // Fecha límite para respuesta
                    'precio' => null, // Inicialmente nulo (rellena desp el prov)
                    'cantidad' => null, // Inicialmente nulo (rellena desp el prov)
                    'tiempo_entrega' => null, // Inicialmente nulo (rellena desp el prov)
                ]);
            }

            // Enviar correo electrónico al proveedor con un enlace unico al formulario de cotización
            $supplier = Supplier::find($supplierId); // Aquí se corrige
            Mail::to($supplier->email)->send(new EnviarCotizacionMail($cotizacion));

            //dd($cotizacion);
        }

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'La cotización ha sido enviada correctamente',
        ]);

        return redirect()->route('admin.cotizaciones.index');
    }





    public function render()
    {
        return view('livewire.admin.cotizaciones.create-cotizacion');
    }
}
