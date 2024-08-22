<?php

namespace App\Livewire\Admin\Products;

use App\Models\Feature;
use App\Models\Option;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ProductVariants extends Component
{

    public $product;

    public $openModal = false;

    public $options;

    public $variant =[
        'option_id' => '',
        'features' => [
            [
                'id' =>'',
                'value' =>'',
                'description' =>''
            ],
        ]
    ];

    //que el usuario pueda elegir una opcion
    //recuperamos todas las opciones que tengamos en el sistema
    public function mount()
    {
        $this->options = Option::all();
    }

    public function updatedVariantOptionId()
    {
        $this->variant['features']=[
            [
                'id' =>'',
                'value' =>'',
                'description' =>''
            ],
        ];
    }


    #[Computed()]
    public function features()
    {
        //retorna todos aquells features cuyos option id coincidan con lo que hemos seleccionado previamente
        return Feature::where('option_id', $this->variant['option_id'])->get();
    }

    public function addFeature()
    {
        //acceder a la propiedad variant
        //acceder a la llave features
        //y agregarle un nuevo array con esos campos
        $this->variant['features'][] = [
            'id' =>'',
            'value' =>'',
            'description' =>''
        ];
    }

    public function feature_change($index)
    {
        $feature = Feature::find($this->variant['features'][$index]['id']);

        if ($feature) {
            $this->variant['features'][$index]['value']= $feature->value;
            $this->variant['features'][$index]['description']= $feature->description;
        }
    }

    //Remueve features dentro del modal
    public function removeFeature($index)
    {
        //eliminamos del array
        unset($this->variant['features'][$index]);

        //refrescamos los indices
        $this->variant['features']= array_values($this->variant['features']);
    }

    public function deleteFeature($option_id, $feature_id){

        $this->product->options()->updateExistingPivot($option_id,[

            'features' => array_filter($this->product->options->find($option_id)->pivot->features, function ($feature) use ($feature_id){
                return $feature['id'] != $feature_id;
            })
        ]);

        $this->product= $this->product->fresh();
        

    }

    public function deleteOption($option_id)
    {
        $this->product->options()->detach($option_id);
        $this->product = $this->product->fresh();
    }

    public function save()
    {

        $this->validate([
            'variant.option_id' => 'required',
            'variant.features.*.id' => 'required',
            'variant.features.*.value' => 'required',
            'variant.features.*.description' => 'required',
        ]);

        $this->product->options()->attach($this->variant['option_id'],[
            'features' => $this->variant['features']
        ]);

        $this->product= $this->product->fresh();

        $this->reset(['variant', 'openModal']);

    }

    public function render()
    {
        return view('livewire.admin.products.product-variants');
    }
}
