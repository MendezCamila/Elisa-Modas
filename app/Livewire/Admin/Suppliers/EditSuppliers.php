<?php
namespace App\Livewire\Admin\Suppliers;

use Livewire\Component;
use App\Models\Supplier;
use Illuminate\Validation\Rule;

class EditSuppliers extends Component
{
    public $supplierId;
    public $name;
    public $last_name;
    public $email;
    public $phone;

    public function mount(Supplier $supplier)
    {
        $this->supplierId = $supplier->id;
        $this->name = $supplier->name;
        $this->last_name = $supplier->last_name;
        $this->email = $supplier->email;
        $this->phone = $supplier->phone;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('suppliers')->ignore($this->supplierId)],
            'phone' => 'nullable|string|max:20',
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
