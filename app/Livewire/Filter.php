<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Product;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;
use Livewire\WithPagination;
use App\Models\Feature;

class Filter extends Component
{
    use WithPagination;

    public $family_id;
    public $options;

    //creamos una propiedad para guardar las features seleccionadas
    public $selected_features = [];
    //creamos una propiedad para guardar el orden del select
    public $orderBy = 1;

    public function mount()
    {

        //en la propiedad options tenemos guardos todas las opciones con sus features de una deter familia
        $this->options = Option::whereHas('products.subcategory.category', function($query){
            $query->where('family_id', $this->family_id);
        })->with([
            'features' => function($query) {
                $query->whereHas('variants.product.subcategory.category', function($query){
                    $query->where('family_id', $this->family_id);
                });
            }
        ])
        ->get()->toArray();
    }

    public function render()
    {
        //mostrar los productos

        $products = Product::whereHas('subcategory.category', function($query){
            $query->where('family_id', $this->family_id);
        })
        ->when($this->orderBy == 1, function($query){
            $query->orderBy('created_at', 'desc');
        })
        ->when($this->orderBy == 2, function($query){
            $query->orderBy('price', 'desc');
        })
        ->when($this->orderBy == 3, function($query){
            $query->orderBy('price', 'asc');
        })
        ->when($this->selected_features, function($query){
            $query->whereHas('variants.features', function($query){
                $query->whereIn('features.id', $this->selected_features);
            });
        })
        ->paginate(12);

        return view('livewire.filter', compact('products'));
    }
}
