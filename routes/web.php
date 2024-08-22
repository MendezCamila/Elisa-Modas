<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
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

//Ruta de Editar variantes
Route::get('products/{product}/variants/{variant}', [ProductController::class, 'variants'])
    ->name('admin.products.variants')
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

Route::get('prueba', function () {

    $product = Product::find(99);

    $features = $product->options->pluck('pivot.features');

    $combinaciones = generarCombinaciones($features);

    //eliminamos todos los productos anteriores
    $product->variants()->delete();

    foreach ($combinaciones as $combinacion) {

        //creamos la variante
        $variant = Variant::create([
            'product_id' => $product->id,
        ]);

        $variant->features()->attach($combinacion);
    }

    return "Variantes creadas";


});

function  generarCombinaciones($arrays, $indice = 0, $combinacion = [])

{

    if ($indice == count($arrays)){

        return [$combinacion];

    }

    $resultado= [];

    foreach ($arrays[$indice] as $item){

        $combinacionesTemporal = $combinacion;

        $combinacionesTemporal[] = $item['id'];

        $resultado = array_merge($resultado, generarCombinaciones($arrays, $indice + 1, $combinacionesTemporal));

    }

    return  $resultado;

}


