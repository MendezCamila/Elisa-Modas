<?php

namespace App\Livewire\Admin\Roles;


use Livewire\Component;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class EditRoles extends Component
{
    public $roleId;
    public $name;
    public $permissions = [];
    public $selectedPermissions = [];

    protected $rules = [
        'name' => 'required|max:255|unique:roles,name,{{roleId}}',
        'selectedPermissions' => 'array',
    ];

    public function mount($roleId)
    {
        // Obtenemos el rol a editar
        $role = Role::findOrFail($roleId);
        // Guardamos el id del rol
        $this->roleId = $role->id;
        // Guardamos el nombre del rol
        $this->name = $role->name;
        // Guardamos los permisos del rol
        $this->permissions = Permission::all();
        // Guardamos los permisos seleccionados
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    public function updateRole()
    {
        // Validar los datos
        $this->validate();

        // Actualizar el rol
        $role = Role::findOrFail($this->roleId);
        // Actualizar el nombre del rol
        $role->name = $this->name;
        // Guardar los cambios
        $role->save();

        // Verificar que los permisos seleccionados existan en la base de datos
        $validPermissions = Permission::whereIn('id', $this->selectedPermissions)->pluck('name')->toArray();
        $role->syncPermissions($validPermissions);

        session()->flash('swal', [
            'icon' => 'success',
            'title' => 'Rol actualizado!',
            'text' => 'El rol ha sido actualizado correctamente',
        ]);

        // Redirigir al listado de roles
        return redirect()->route('admin.roles.index');
    }

    public function render()
    {
        return view('livewire.admin.roles.edit-roles');
    }
}
