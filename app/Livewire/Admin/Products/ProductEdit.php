<?php

namespace App\Livewire\Admin\Products;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductEdit extends Component
{
    use WithFileUploads;
    //Recibimos el producto que queremos editar
    public $product;
    public $productEdit;

    public $families; //en esta propiedad vamos a almacenar todas las familias q tengamos registradas
    public $family_id = ''; //almacena el id de la familia
    public $category_id = ''; //id de la categoria seleccionada
    public $subcategory_id = '';

    public $image;


    public function mount($product)
    {
        $this->productEdit = $product->only('sku','name','descripcion','image_path','price','subcategory_id');
        $this->families = Family::all();
        $this->category_id = $product->subcategory->category->id;
        $this->family_id = $product->subcategory->category->family_id;
    }


    public function boot()
    {
        $this->withValidator(function ($validator) {
            if ($validator->fails()) {

                $this->dispatch('swal',[
                    'icon' => 'error',
                    'title' => 'Error!',
                    'text' => 'El formulario contiene errores.',
                ]);
            }
        });
    }

    public function updatedFamilyId($value)
    {

        $this->category_id = '';
        $this->productEdit['subcategory_id'] = '';
    }

    public function updatedCategoryId($value)
    {
        $this->productEdit['subcategory_id'] = '';
    }

    #[Computed()]
    public function categories()
    {
        return Category::where('family_id', $this->family_id)->get();
    }

    #[Computed()]
    public function subcategories()
    {
        return Subcategory::where('category_id', $this->category_id)->get();
    }

    public function store()
    {
        $this->validate([
            'image' => 'nullable|image|max:1024',
            'productEdit.sku' => 'required|unique:products,sku,' . $this->product->id,
            'productEdit.name' => 'required|max:255',
            'productEdit.descripcion' => 'nullable',
            'productEdit.price' => 'required|numeric|min:0',
            'productEdit.subcategory_id' => 'required|exists:subcategories,id',
        ]);

        if ($this->image) {

            Storage::delete($this->productEdit['image_path']);
            $this->productEdit['image_path']= $this->image->store('products');
        }

        $this->product->update($this->productEdit);

       session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Producto actualizado!',
            'text' => 'Producto actualizado correctamente',
        ]); 

        return redirect()->route('admin.products.index', $this->product);

    }

    public function render()
    {
        return view('livewire.admin.products.product-edit');
    }
}
