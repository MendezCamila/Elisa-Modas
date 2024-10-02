<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Component;

class EditUsers extends Component
{
    public $user;
    public $roles;
    public $selectedRoles = [];

    public function mount(User $user)
    {
        // Asigna el usuario
        $this->user = $user;

        // Obtén todos los roles disponibles
        $this->roles = Role::all();

        // Asigna los roles actuales del usuario en formato de IDs
        $this->selectedRoles = $user->roles->pluck('id')->toArray(); // Usar IDs de roles
    }

    public function updateRoles()
    {
        // Sincronizar roles utilizando directamente los IDs de los roles seleccionados
        $this->user->roles()->sync($this->selectedRoles);

        // Emitir evento para mostrar la alerta
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado!',
            'text' => 'Roles actualizados correctamente',
        ]);

        return redirect()->route('admin.users.index');
    }



    public function render()
    {
        return view('livewire.admin.users.edit-users');
    }
}
