<?php

namespace App\Livewire;

use App\Models\Option;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class Filter extends Component
{
    public $family_id;
    public $options;

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
        ->get();
    }

    public function render()
    {
        return view('livewire.filter');
    }
}
