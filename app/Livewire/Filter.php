<?php

namespace App\Livewire;

use App\Models\Option;
use App\Models\Product;
use Livewire\Component;
use Illuminate\Database\Eloquent\Builder;
use phpDocumentor\Reflection\Types\This;
use Livewire\WithPagination;
use App\Models\Feature;
use Livewire\Attributes\On;
use App\Models\Family;


class Filter extends Component
{
    use WithPagination;

    public $family_id;
    public $category_id;
    public $options;
    public $subcategory_id;

    //creamos una propiedad para guardar las features seleccionadas
    public $selected_features = [];
    //creamos una propiedad para guardar el orden del select
    public $orderBy = 1;

    public $search;

    public function mount()
    {

        $this->options = Option::verifyFamily($this->family_id)
        ->verifyCategory($this->category_id)
        ->verifySubcategory($this->subcategory_id)
        ->get()->toArray();
    }

    #[On('search')]
    public function search($search)
    {
        $this->search = $search;
    }

    public function render()
    {
        //mostrar los productos

        $products = Product::verifyFamily($this->family_id)
            ->verifyCategory($this->category_id)
            ->verifySubcategory($this->subcategory_id)
            ->customOrder($this->orderBy)
            ->selectFeatures($this->selected_features)
            ->when($this->search, function($query){
                $query->where('name', 'like', '%'.$this->search.'%');
            })
            ->paginate(12);

        return view('livewire.filter', compact('products'));
    }
}
