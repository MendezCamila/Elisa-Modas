<?php
namespace App\Livewire\Admin\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use App\Rules\ValidCuit;

class CreateSuppliers extends Component
{
    public $name;
    public $last_name;
    public $phone;
    public $email;
    public $cuit;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'cuit' => ['required', 'string', 'size:11', 'unique:suppliers,cuit', new ValidCuit],
        ];
    }

    public function createSupplier()
    {
        $this->validate();

        Supplier::create([
            'name' => strtoupper($this->name),
            'last_name' => strtoupper($this->last_name),
            'email' => strtoupper($this->email),
            'phone' => strtoupper($this->phone),
            'cuit' => $this->cuit,
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
