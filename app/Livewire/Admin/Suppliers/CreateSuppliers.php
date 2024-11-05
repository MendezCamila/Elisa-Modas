<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Family;
use App\Models\Subcategory;
use Livewire\Component;
use App\Models\Supplier;
use App\Rules\CuitCuilRule;

class CreateSuppliers extends Component
{
    public $name;
    public $last_name;
    public $phone;
    public $email;
    public $cuit;


    public $subcategory_ids = []; // Agrega esta propiedad para almacenar los IDs de subcategorías seleccionadas
    public $subcategories = [];



    public function mount()
    {
        $this->subcategories = Subcategory::with('category.family')->get();
        $this->dispatch('initializeSelect2');
    }

    public function hydrate()
    {
        $this->dispatch('initializeSelect2');
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'cuit' => ['required', new CuitCuilRule],
            'subcategory_ids' => 'required|array|min:1', // Regla de validación para los IDs seleccionados
        ];
    }

    protected function messages()
    {
        return [
            'subcategory_ids.required' => 'Debe seleccionar al menos una subcategoría.',
            'subcategory_ids.min' => 'Debe seleccionar al menos una subcategoría.',
        ];
    }


    public function updatedSubcategoryIds($value)
    {
        // Actualizar los IDs de subcategorías cuando cambian
        $this->subcategory_ids = $value;
    }


    public function createSupplier()
    {
        $this->validate();

        $supplier = Supplier::create([
            'name' => strtoupper($this->name),
            'last_name' => strtoupper($this->last_name),
            'email' => $this->email,
            'phone' => strtoupper($this->phone),
            'cuit' => $this->cuit,
        ]);

        // Sincroniza las subcategorías seleccionadas en la tabla intermedia
        $supplier->subcategories()->sync($this->subcategory_ids);

        // Mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Proveedor creado!',
            'text' => 'El proveedor ha sido creado correctamente',
        ]);

        return redirect()->route('admin.suppliers.index');
    }

    public function render()
    {
        return view('livewire.admin.suppliers.create-suppliers');
    }
}
