<?php

namespace App\Livewire\Forms\Admin\Options;

use App\Models\Option;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Form;

class NewOptionForm extends Form
{
    //Creamos las propiedades
    public $name;
    public $type = 1;
    public $features = [
        [
            'value'=>'',
            'description'=>'',
        ],
    ];

    public $openModal = false;


     //VALIDACIONES
    public function rules(){

        $rules= [
            'name'=> 'required',
            'type'=> 'required|in:1,2',
            'features'=> 'required|array|min:1',

        ];

        foreach ($this->features as $index => $feature) {

            if ($this->type == 1) {
                // Si el tipo es 1, el valor es requerido
                $rules['features.'.$index.'.value'] = 'required';
            } else {
                // Si no es del tipo 1, comprobamos que el valor sea un color hexadecimal válido
                $rules['features.'.$index.'.value'] = 'required|regex:/^#[a-f0-9]{6}$/i';
            }

            // La descripción es requerida y tiene un límite de 255 caracteres
            $rules['features.'.$index.'.description'] = 'required|max:255';
        }

        return $rules;
    }

    public function validationAttributes(){

        $attributes = [
            'name'=> 'nombre',
            'type'=> 'tipo',
            'features'=> 'valores',
        ];

        foreach ($this->features as $index => $feature) {
            $attributes['features.'.$index.'.value']= 'valor '.($index + 1) ;
            $attributes['features.'.$index.'.description']= 'descripcion '.($index + 1);
        }

        return $attributes;
    }

    //Añadir feature
    public function addFeature(){
        $this->features[]=[
            'value'=>'',
            'description'=>'',
        ];
    }

    //eliminar feature
    public function removeFeature($index){
        unset($this->features[$index]);
        $this->features =array_values($this->features);
    }

    //Metodo que se encarga de crear la opcion
    public function save(){

        $this->validate();

        //procedemos a CREAR LA OPCION
        $option = Option::create([
            'name'=> $this->name,
            'type'=> $this->type,
        ]);

        //creamos sus FEATURES
        foreach ($this->features as $feature) {
            $option->features()->create([
                'value' => $feature['value'],
                'description' => $feature['description'],
            ]);
        }

        $this->reset();
    }

}
