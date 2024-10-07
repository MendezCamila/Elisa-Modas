<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;

class EditUsers extends Component
{
    public $user;
    public $name;
    public $last_name;
    public $email;
    public $phone;
    public $roles;
    public $selectedRoles = [];

    protected $rules = [
        'name' => 'required|max:255',
        'last_name' => 'required|max:255',
        'email' => 'required|email|max:255|unique:users,email,{{user->id}}',
        'phone' => 'required|max:20',
        'selectedRoles' => 'array',
    ];

    public function mount(User $user)
    {
        // Asigna el usuario
        $this->user = $user;
        $this->name = $user->name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->phone = $user->phone;

        // Obtén todos los roles disponibles
        $this->roles = Role::all();

        // Asigna los roles actuales del usuario en formato de IDs
        $this->selectedRoles = $user->roles->pluck('id')->toArray();
    }

    public function updateUser()
    {
        $this->validate();

        $this->user->name = $this->name;
        $this->user->last_name = $this->last_name;
        $this->user->email = $this->email;
        $this->user->phone = $this->phone;

        $this->user->save();

        // Sincronizar roles utilizando directamente los IDs de los roles seleccionados
        $this->user->roles()->sync($this->selectedRoles);

        // Emitir evento para mostrar la alerta
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario actualizado!',
            'text' => 'El usuario ha sido actualizado correctamente',
        ]);

        return redirect()->route('admin.users.index');
    }



    public function render()
    {
        return view('livewire.admin.users.edit-users');
    }
}
