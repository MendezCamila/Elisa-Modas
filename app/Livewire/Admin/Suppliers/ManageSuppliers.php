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

    public function render()
    {
        $suppliers = Supplier::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc') // Ordenar por id en orden descendente
            ->paginate(10);

        return view('livewire.admin.suppliers.manage-suppliers', [
            'suppliers' => $suppliers,
        ]);
    }
}
