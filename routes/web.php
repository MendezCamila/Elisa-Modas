<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CoverController;
use App\Http\Controllers\Admin\FamilyController;
use App\Http\Controllers\Admin\OptionController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\CotizacionController;
use App\Http\Controllers\Admin\OrdenCompraController;
use App\Http\Controllers\Admin\PdfExportController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MercadoPagoWebhookController;
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
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\VentasController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\PurchaseController;
use App\Models\Ventas;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');

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



Route::get('prueba', function () {
    $venta = Ventas::first();

    $pdf = Pdf::loadView('ventas.ticket', compact('venta'))->setPaper('a5');

    //visualiza el pdf
    return $pdf->stream();

    //almacena el pdf
    $pdf->save(storage_path('app/public/tickets/ticket-' . $venta->id . '.pdf'));

    $venta->pdf_path = 'tickets/ticket-' . $venta->id . '.pdf';
    $venta->save();
});


Route::middleware(['web', 'auth', 'can:acceso dashboard'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
});


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



// Rutas para administrar usuarios
Route::middleware(['web', 'auth', 'can:administrar usuarios'])->prefix('admin')->name('admin.')->group(function () {
    // Ruta para listar usuarios
    Route::get('users', [UserController::class, 'index'])->name('users.index');

    // Ruta para crear un usuario
    Route::get('users/create', [UserController::class, 'create'])->name('users.create');

    // Ruta para almacenar un nuevo usuario
    Route::post('users', [UserController::class, 'store'])->name('users.store');

    // Ruta para editar un usuario
    Route::get('users/{user}', [UserController::class, 'edit'])->name('users.edit');

    // **Ruta para eliminar un usuario**
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
});

// Rutas para administrar roles
Route::middleware(['web', 'auth'/*, 'can:administrar roles'*/])->prefix('admin')->name('admin.')->group(function () {
    // Ruta para listar roles
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');

    // Ruta para crear un rol
    Route::get('roles/create', [RoleController::class, 'create'])->name('roles.create');

    // Ruta para almacenar un nuevo rol
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');

    //Ruta para editar un rol
    Route::get('roles/{role}', [RoleController::class, 'edit'])->name('roles.edit');

    // Ruta para actualizar un rol
    //Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');

    // Ruta para eliminar un rol
    //Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
});

// Rutas para administrar proveedores
Route::middleware(['web', 'auth', /*'can:administrar proveedores'*/])->prefix('admin')->name('admin.')->group(function () {
    // Ruta para listar proveedores
    Route::get('suppliers', [SupplierController::class, 'index'])->name('suppliers.index');


    // Ruta para crear un proveedor
    Route::get('suppliers/create', [SupplierController::class, 'create'])->name('suppliers.create');


    // Ruta para editar un proveedor
    Route::get('suppliers/{supplier}', [SupplierController::class, 'edit'])->name('suppliers.edit');


    // Ruta para eliminar un proveedor
    Route::delete('suppliers/{supplier}', [SupplierController::class, 'destroy'])->name('suppliers.destroy');
});

//Ruta para administrar la auditoria
Route::middleware(['web', 'auth', /*'can:administrar auditoria'*/])->prefix('admin')->name('admin.')->group(function () {
    Route::get('auditorias', [AuditController::class, 'index'])->name('auditorias.index');
});


//Ruta para administrar Cotizaciones
Route::middleware(['web', 'auth', /*'can:administrar cotizaciones'*/])->prefix('admin')->name('admin.')->group(function () {
    Route::get('cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones.index');
    //ruta para crear una nueva cotizacion
    Route::get('cotizaciones/create', [CotizacionController::class, 'create'])->name('cotizaciones.create');
    //ruta para mostrar cotizacion desde admin
    Route::get('cotizaciones/{id}/admin', [CotizacionController::class, 'showAdmin'])->name('cotizaciones.showAdmin');
    //ruta para mostrar respuesta del proveedor
    Route::get('cotizaciones/{id}/respuesta', [CotizacionController::class, 'respuesta'])->name('cotizaciones.respuesta');
    //ruta para generar cotizacion automatica
    Route::get('cotizaciones/generar', [CotizacionController::class, 'generar'])->name('cotizaciones.generar');
});


//Ruta para administrar las ordenes de compra
Route::middleware(['web', 'auth', /*'can:administrar ordenes de compra'*/])->prefix('admin')->name('admin.')->group(function () {
    Route::get('ordenes-compra', [OrdenCompraController::class, 'index'])->name('orden-compras.index');
    Route::get('ordenes-compras/create/{cotizacion_id}', [OrdenCompraController::class, 'create'])->name('orden-compras.create');
    Route::get('/orden-compras/{id}', [OrdenCompraController::class, 'show'])->name('orden-compras.show');
    Route::get('orden-compras/{id}', [OrdenCompraController::class, 'showAdmin'])->name('orden-compras.showAdmin');
    Route::get('export/orden-compras/pdf', [PdfExportController::class, 'exportOrdenesCompra'])->name('orden-compras.pdf');
});



//previsualizar como queda el correo que vera el proveedor http://elisamodas.test/previsualizar-cotizacion
Route::get('/previsualizar-cotizacion', function () {
    $cotizacion = (object) [
        'id' => 123, // ID ficticio para la cotización
    ];

    return view('admin.emails.cotizacion', compact('cotizacion'));
});

Route::get('/cotizacion/{id}', [CotizacionController::class, 'show'])->name('cotizacion.show');



//Ruta para administrar las ventas
Route::middleware(['web', 'auth', /*'can:administrar ventas'*/])->prefix('admin')->name('admin.')->group(function () {
    Route::get('ventas', [VentasController::class, 'index'])->name('ventas.index');
    Route::get('ventas/informepdf', [PdfExportController::class, 'exportVentas'])->name('ventas.informepdf');
});


//Rutas para pagar con MercadoPago
//Route::get('/payment/create', [PaymentController::class, 'createPreference'])->name('payment.create');
Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure');
Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
Route::get('/download/ticket/{id}', [PaymentController::class, 'downloadTicket'])->name('download.ticket');


//Ruta para ver "mis compras" (parte cliente)
Route::middleware(['auth'])->group(function () {
    Route::get('/mis-compras', [PurchaseController::class, 'index'])->name('purchases.index');
    Route::get('/mis-compras/{id}', [PurchaseController::class, 'show'])->name('purchases.show');
});

Route::get('/ventas/{id}/descargar-comprobante', [PaymentController::class, 'descargarComprobante'])
    ->name('ventas.descargarComprobante');







Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
