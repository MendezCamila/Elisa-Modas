<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    //return view('admin'); // Aquí puedes retornar una vista o cualquier respuesta que desees
    //return view('admin.dashboard');
    return "hola desde admin";
})->name('dashboard');



