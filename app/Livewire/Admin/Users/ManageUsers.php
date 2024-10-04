<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ManageUsers extends Component
{
    use WithPagination;

    public $search;

    

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Recuperamos todos los usuarios que coincidan con la búsqueda
        $users = User::where('name', 'LIKE', '%' . $this->search . '%')
            ->orWhere('email', 'LIKE', '%' . $this->search . '%')
            ->orWhere('last_name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'desc') // Ordenar por id en orden descendente
            ->paginate(10);
            

        // Una vez recuperamos los usuarios, los pasamos a la vista
        return view('livewire.admin.users.manage-users', compact('users'));
    }
}
