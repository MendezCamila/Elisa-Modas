<?php

namespace App\Livewire\Admin\Suppliers;

use App\Models\Supplier;
use Livewire\Component;
use Livewire\WithPagination;

class ManageSuppliers extends Component
{
    use WithPagination;

    public $search = '';

    protected $queryString = ['search'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->listeners = [
            'desactivarSupplier' => 'desactivarSupplier',
        ];
    }

    public function desactivarSupplier($supplierId)
    {
        $supplier = Supplier::find($supplierId);
        if ($supplier) {
            $supplier->estado = 'no activo';
            $supplier->save();
        }

        //refrescamos la informacion
        $this->suppliers = Supplier::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orWhere('cuit', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);
    }




    public function render()
{
    $suppliers = Supplier::where('name', 'like', '%' . $this->search . '%')
        ->orWhere('email', 'like', '%' . $this->search . '%')
        ->orWhere('cuit', 'like', '%' . $this->search . '%')
        ->orderBy('id', 'desc')
        ->paginate(10);

    return view('livewire.admin.suppliers.manage-suppliers', [
        'suppliers' => $suppliers,
    ]);
}
}
