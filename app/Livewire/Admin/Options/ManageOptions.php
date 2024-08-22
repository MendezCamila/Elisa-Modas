<?php

namespace App\Livewire\Admin\Options;

use App\Livewire\Forms\Admin\Options\NewOptionForm;
use App\Models\Feature;
use App\Models\Option;
use Livewire\Attributes\On;
use Livewire\Component;

class ManageOptions extends Component
{

    //defino una variable options porq quiero recuperar todas las opciones
    public $options;



    public NewOptionForm $newOption;


    public function mount()
    {
        $this->options = Option::with('features')->get();
    }

    #[On('featureAdded')]
    public function updateOptionList()
    {
        $this->options = Option::with('features')->get();
    }

    public function addFeature()
    {
        $this->newOption->addFeature();
    }

    public function deleteFeature(Feature $feature)
    {
        $feature->delete();

        //refrescar la informacion
        $this->options = Option::with('features')->get();
    }

    public function deleteOption(Option $option)
    {
        //eliminamos
        $option->delete();

        //refrescamos la coleccion
        $this->options = Option::with('features')->get();
    }


    public function removeFeature($index)
    {
        $this->newOption->removeFeature($index);
    }

    public function addOption()
    {
        $this->newOption->save();

        $this->options = Option::with('features')->get();

        $this->dispatch('swal', [
            'icon' => 'success',
            'title' => 'Bien hecho!',
            'text' => 'La opcion se agrego correctamente!',
        ]);

    }




    public function render()
    {
        return view('livewire.admin.options.manage-options');
    }
}
