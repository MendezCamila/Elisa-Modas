<?php

namespace App\Livewire\Admin\Roles;

use Livewire\Component;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;

class ManageRoles extends Component
{
    use WithPagination;
    public $search;

    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function render()
    {
        $roles = Role::where('name', 'LIKE', '%' . $this->search . '%')
            ->orderBy('id', 'DESC')
            ->paginate(10);
        return view('livewire.admin.roles.manage-roles', compact('roles'));
    }

    public function delete($id)
    {
        Role::findOrFail($id)->delete();

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol eliminado!',
            'text' => 'El rol ha sido eliminado correctamente',
        ]);

        return redirect()->route('admin.roles.index');
    }
}
