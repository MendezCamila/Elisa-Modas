<?php

namespace App\Livewire\Admin\Users;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateUsers extends Component
{
    //recibimos los roles
    public $roles;
    //recibimos los datos del formulario
    public $name;
    public $last_name;
    public $email;
    public $phone;
    public $password;
    public $password_confirmation;
    public $selectedroles = [];

    public function createUser()
    {
        $this->validate([
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|max:15',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|array',
        ]);

        $user = User::create([
            'name' => $this->name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'password' => Hash::make($this->password),
        ]);

        $user->syncRoles($this->roles);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Usuario creado!',
            'text' => 'El usuario ha sido creado correctamente',
        ]);

        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.admin.users.create-users');
    }


}
