<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CoverController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\FamiliaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\WelcomeController;
use App\Livewire\Admin\UserComponent;
use App\Models\Product;
use App\Models\Variant;
use CodersFree\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Route;


Route::get('/',[WelcomeController::class, 'index'] )->name('welcome.index');

//filtrar productos por familia
Route::get('families/{family}', [FamiliaController::class, 'show'])->name('families.show');

//filtrar productos por categoria
Route::get('categories/{category}', [CategoriaController::class, 'show'])->name('categories.show');

//filtrar productos por subcategoria
Route::get('subcategories/{subcategory}', [SubcategoriaController::class, 'show'])->name('subcategories.show');

//mostrar detalle de producto
Route::get('products/{product}', [ProductoController::class, 'show'])->name('products.show');

//Mostrar items del carrito de compras
Route::get('cart', [CartController::class, 'index'])->name('cart.index');



Route::get('prueba', function(){
    Cart::instance('shopping');
    return Cart::content();
});


//Ruta Administrador
Route::get('/admin', function () {
    return view('admin.dashboard');
})->middleware('can:acceso dashboard')
->name('admin.dashboard');


//Ruta Resource (agregar el prefijo admin ya que hago todo dentro de web.php)
Route::middleware(['web', 'auth', 'can:administrar familias'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('families', FamilyController::class);
});

//Ruta de Categorias
Route::middleware(['web', 'auth', 'can:administrar categorias'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', CategoryController::class);
});
//Ruta de Subcategorias
Route::middleware(['web', 'auth', 'can:administrar subcategorias'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('subcategories', SubcategoryController::class);
});
//Ruta de Productos
Route::middleware(['web', 'auth', 'can:administrar productos'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
});

//Ruta de Opciones de productos
Route::middleware(['web', 'auth', 'can:administrar opciones'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('options', OptionController::class);
});

//Ruta de portada
Route::middleware(['web', 'auth', 'can:administrar portadas'])->prefix('admin')->name('admin.')->group(function () {
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

// Ruta crear crud para usuarios
Route::middleware(['web', 'auth', 'can:administrar usuarios'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users', [UserController::class, 'index'])->name('users.index');
});
// Ruta para editar usuarios
Route::middleware(['web', 'auth', 'can:administrar usuarios'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('users/{user}', [UserController::class, 'edit'])->name('users.edit');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});




