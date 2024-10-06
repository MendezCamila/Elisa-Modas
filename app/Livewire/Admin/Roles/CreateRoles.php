<?php

namespace App\Livewire\Admin\Roles;


use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Livewire\Component;

class CreateRoles extends Component
{
    public $name;
    public $permissions = [];
    public $selectedPermissions = [];

    protected $rules = [
        'name' => 'required|max:255|unique:roles,name',
        'selectedPermissions' => 'array',
    ];

    public function mount()
    {
        // Recuperamos todos los permisos
        $this->permissions = Permission::all();
    }

    public function createRole()
    {
        $this->validate();

        $role = Role::create(['name' => $this->name]);

        // Verificar que los permisos seleccionados existan en la base de datos
        $validPermissions = Permission::whereIn('id', $this->selectedPermissions)->pluck('name')->toArray();
        $role->syncPermissions($validPermissions);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol creado!',
            'text' => 'El rol ha sido creado correctamente',
        ]);

        // Redirigir al listado de roles
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        return view('livewire.admin.roles.create-roles');
    }
}
