<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    //retornar vista index
    public function index()
    {
        return view('admin.reservas.index');
    }
}
