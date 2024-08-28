<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CoverController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\WelcomeController;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Route;

Route::get('/',[WelcomeController::class, 'index'] )->name('welcome.index');

//filtrar productos por familia
Route::get('families/{family}', [FamiliaController::class, 'show'])->name('families.show');

//Ruta Administrador
Route::get('/admin', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

//Ruta Resource (agregar el prefijo admin ya que hago todo dentro de web.php)
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('families', FamilyController::class);
});
//Ruta de Categorias
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});
//Ruta de Subcategorias
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('subcategories', SubcategoryController::class);
});
//Ruta de Productos
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});

//Ruta de Opciones
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('options', OptionController::class);
});

//Ruta de portada
Route::middleware(['web', 'auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('covers', CoverController::class);
});

//Ruta de Editar variantes
Route::get('products/{product}/variants/{variant}', [ProductController::class, 'variants'])
    ->name('admin.products.variants')
    ->scopeBindings();

//Ruta actualizar variantes
Route::put('products/{product}/variants/{variant}', [ProductController::class, 'variantsUpdate'])
    ->name('admin.products.variantsUpdate')
    ->scopeBindings();



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});




