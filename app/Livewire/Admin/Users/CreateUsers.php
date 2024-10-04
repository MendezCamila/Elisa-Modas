<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;


class CreateUsers extends Component
{
    // Recibir los roles disponibles
    public $roles;
    
    // Datos del formulario
    public $name;
    public $last_name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    
    // Roles seleccionados
    public $selectedroles = [];

    public function createUser()
    {
        // Validar los datos de entrada
        $this->validate([
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|max:15',
            'password' => 'required|min:8|confirmed',
        ]);

        // Crear el usuario
        $user = User::create([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        // Verificar si hay roles seleccionados
        if (!empty($this->selectedroles)) {
            // Buscar los roles por ID antes de asignarlos
            $rolesToSync = Role::whereIn('id', $this->selectedroles)->get();
            $user->syncRoles($rolesToSync);
        } else {
            // Eliminar todos los roles si no se seleccionaron
            $user->syncRoles([]); // Dejar al usuario sin roles
        }

        // Mensaje de éxito
        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario creado!',
            'text' => 'El usuario ha sido creado correctamente',
        ]);

        // Redirigir al listado de usuarios
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        // Obtener los roles para mostrarlos en la vista
        $this->roles = Role::all();

        return view('livewire.admin.users.create-users');
    }
}
