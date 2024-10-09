<?php

namespace App\Livewire\Admin\Products;

use App\Models\Feature;
use App\Models\Option;
use App\Models\Variant;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Computed;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class ProductVariants extends Component
{

    public $product;

    public $openModal = false;

    // public $options;

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

    public $variantEdit = [
        'open' => false,
        'id' => null,
        'stock' => null,
        'sku' => null,
    ];

    public $new_feature = [
        /* estructura que quiero que tenga
        $option->id => $feature->id
        */

    ];

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
    public function options()
    {
        return Option::whereDoesntHave('products', function ($query){
            $query->where('product_id', $this->product->id);
        })->get();
    }


    #[Computed()]
    public function features()
    {
        //retorna todos aquells features cuyos option id coincidan con lo que hemos seleccionado previamente
        return Feature::where('option_id', $this->variant['option_id'])->get();
    }


    public function addNewFeature( $option_id )
    {
        $this->validate([
            'new_feature.'.$option_id => 'required',
        ]);

        $feature = Feature::find($this->new_feature[$option_id]);

        $this->product->options()->updateExistingPivot($option_id,[
            'features' => array_merge($this->product->options->find($option_id)->pivot->features, [
                [
                    'id' => $feature->id,
                    'value' => $feature->value,
                    'description' => $feature->description,
                ]
            ])
        ]);

        $this->product = $this->product->fresh();

        $this->new_feature[ $option_id ] = '';

        $this->generarVariantes();
    }


    public function getFeatures($option_id )
    {
        $features = DB::table('option_product')
            ->where('product_id', $this->product->id)
            ->where('option_id', $option_id)
            ->first()
            ->features;

        $features = collect(json_decode($features))->pluck('id');


        return Feature::where('option_id', $option_id )
            ->whereNotIn('id', $features)
            ->get();
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

        //obtenemos las variantes que tiene el producto, pero que estas variantes tengan alguna relacion
        //con el feature que estoy por eliminar
        Variant::where('product_id', $this->product->id)
            ->whereHas('features', function ($query) use ($feature_id){
                $query->where('features.id', $feature_id);
            })->delete();

        $this->product= $this->product->fresh();

        //$this->generarVariantes();


    }

    public function deleteOption($option_id)
    {
        $this->product->options()->detach($option_id);
        $this->product = $this->product->fresh();

        $this->product->variants()->delete();

        $this->generarVariantes();
    }

    public function save()
    {

        $this->validate([
            'variant.option_id' => 'required',
            'variant.features.*.id' => 'required',
            'variant.features.*.value' => 'required',
            'variant.features.*.description' => 'required',
        ]);

        //recuperamos todos los features seleccionados por el usuario
        $features = collect($this->variant['features']);
        //recuperamos aquellos features que sean unicos
        $features = $features->unique('id')->values()->all();



        $this->product->options()->attach($this->variant['option_id'],[
            'features' => $features
        ]);

        //$this->product= $this->product->fresh();
        $this->product->variants()->delete();

        $this->generarVariantes();

        $this->reset(['variant', 'openModal']);

    }

    public function generarVariantes()
    {
        $features = $this->product->options->pluck('pivot.features');
        $combinaciones = $this->generarCombinaciones($features);



        foreach ($combinaciones as $combinacion) {

            $variant = Variant::where('product_id', $this->product->id)
                ->has('features', count($combinacion))
                ->whereHas('features', function ($query) use ($combinacion){
                    $query->whereIn('feature_id', $combinacion);
                })
                ->whereDoesntHave('features', function ($query) use ($combinacion){
                    $query->whereNotIn('feature_id', $combinacion);
                })->first();

            if ($variant) {
                continue;
            }

            //creamos la variante
            $variant = Variant::create([
                'product_id' => $this->product->id,
            ]);

            $variant->features()->attach($combinacion);
        }
        $this->dispatch('variant-generate');

    }

    function  generarCombinaciones($arrays, $indice = 0, $combinacion = [])
    {
        if ($indice == count($arrays)){

            return [$combinacion];

        }

        $resultado= [];

        foreach ($arrays[$indice] as $item){

            $combinacionesTemporal = $combinacion;

            $combinacionesTemporal[] = $item['id'];

            $resultado = array_merge($resultado, $this->generarCombinaciones($arrays, $indice + 1, $combinacionesTemporal));

        }
        return  $resultado;

    }

    public function editVariant(Variant $variant)
    {
        $this->variantEdit = [
            'open' => true,
            'id' => $variant->id,
            'stock' => $variant->stock,
            'sku' => $variant->sku,
        ];
    }

    public function updateVariant()
    {
        $this->validate([
            'variantEdit.stock' => 'required|numeric',
            'variantEdit.sku' => 'required',
        ]);

        $variant = Variant::find($this->variantEdit['id']);

        $variant->update([
            'stock' => $this->variantEdit['stock'],
            'sku' => $this->variantEdit['sku'],
        ]);



        $this->reset('variantEdit');
        $this->product = $this->product->fresh();
        //mensaje swal de actualizado correctamente
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Variante actualizada!',
            'text' => 'La variante ha sido actualizada correctamente',
        ]);
    }

    public function render()
    {
        return view('livewire.admin.products.product-variants');
    }
}
