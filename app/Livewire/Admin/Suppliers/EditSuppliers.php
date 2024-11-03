<?php

namespace App\Livewire\Admin\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Illuminate\Validation\Rule;
use App\Rules\CuitCuilRule;

class EditSuppliers extends Component
{
    public $supplierId;
    public $name;
    public $last_name;
    public $email;
    public $phone;
    public $cuit;

    public function mount(Supplier $supplier)
    {
        $this->supplierId = $supplier->id;
        $this->name = $supplier->name;
        $this->last_name = $supplier->last_name;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;
        $this->cuit = $supplier->cuit;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('suppliers')->ignore($this->supplierId)],
            'phone' => 'nullable|string|max:20',
            'cuit' => ['required', Rule::unique('suppliers')->ignore($this->supplierId), new CuitCuilRule],
        ];
    }


    public function updateSupplier()
    {
        $this->validate();

        $supplier = Supplier::find($this->supplierId);
        $supplier->update([
            'name' => strtoupper($this->name),
            'last_name' => strtoupper($this->last_name),
            'phone' => strtoupper($this->phone),
            'email' =>$this->email,
            'cuit' => $this->cuit,
        ]);

        // Emitir evento para mostrar la alerta
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Proveedor actualizado!',
            'text' => 'El proveedor ha sido actualizado correctamente',
        ]);

        return redirect()->route('admin.suppliers.index');
    }

    public function render()
    {
        return view('livewire.admin.suppliers.edit-suppliers');
    }
}
