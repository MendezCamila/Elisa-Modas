<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //retornamos la vista index
    public function index(){
        return view('admin.users.index');
    }
}
