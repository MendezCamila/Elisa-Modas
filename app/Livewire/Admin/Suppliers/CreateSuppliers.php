<?php

namespace App\Livewire\Admin\Suppliers;
use App\Models\Supplier;

use Livewire\Component;

class CreateSuppliers extends Component
{
    public $name;
    public $last_name;
    public $phone;
    public $email;

    protected $rules = [
        'name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:suppliers,email',
        'phone' => 'nullable|string|max:20',
    ];

    public function createSupplier()
    {
        $this->validate();

        Supplier::create([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
        ]);

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
