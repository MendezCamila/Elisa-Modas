<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //retornamos la vista index
    public function index(){
        return view('admin.users.index');
    }

    //retornamos la vista edit
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    //crear usuario
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }
}
