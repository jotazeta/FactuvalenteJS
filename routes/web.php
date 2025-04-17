<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/linkstorage', function () {
    $targetFolder = base_path().'/storage/app/public';
    $linkFolder = $_SERVER['DOCUMENT_ROOT'].'/storage';
    symlink($targetFolder, $linkFolder); 
});

Route::get('/clear', function () {
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
});

Route::get('generate', function (){
    \Illuminate\Support\Facades\Artisan::call('storage:link');
    echo 'ok';
});

Auth::routes();


// middleware auth
Route::group(['middleware' => ['auth']], function () {
    


    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/demo', [App\Http\Controllers\HomeController::class, 'demo'])->name('demo');
    
    // route resource categories
    Route::get('/categories', [App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categoriesCreate', [App\Http\Controllers\CategoryController::class, 'categoriesCreate'])->name('categoriesCreate');
    Route::post('/categoriesEdit', [App\Http\Controllers\CategoryController::class, 'categoriesEdit'])->name('categoriesEdit');
    Route::post('/categoriesDel', [App\Http\Controllers\CategoryController::class, 'categoriesDel'])->name('categoriesDel');

    // route resource codigo
    Route::get('/codigo', [App\Http\Controllers\CodigoController::class, 'index'])->name('codigo.index');
    Route::post('/codigoCreate', [App\Http\Controllers\CodigoController::class, 'codigoCreate'])->name('codigoCreate');
    Route::post('/codigoEdit', [App\Http\Controllers\CodigoController::class, 'codigoEdit'])->name('codigoEdit');
    Route::post('/codigoDel', [App\Http\Controllers\CodigoController::class, 'codigoDel'])->name('codigoDel');

    // route resource clientes
    // clientes GET routes
    Route::get('/clientes', [App\Http\Controllers\ClientesController::class, 'index'])->name('clientes.index');
    // clientes POST routes
    Route::post('/createClient', [App\Http\Controllers\ClientesController::class, 'createClient'])->name('createClient');
    Route::post('/editClient', [App\Http\Controllers\ClientesController::class, 'editClient'])->name('editClient');
    Route::post('/desactivarCliente', [App\Http\Controllers\ClientesController::class, 'desactivarCliente'])->name('desactivarCliente');
    Route::post('/clientesDel', [App\Http\Controllers\ClientesController::class, 'clientesDel'])->name('clientesDel');


     // route resource products
    Route::get('/productos', [App\Http\Controllers\ProductController::class, 'index'])->name('productos.index');
    Route::get('/servicios', [App\Http\Controllers\ProductController::class, 'servicios'])->name('servicios');
    Route::get('/combos', [App\Http\Controllers\ProductController::class, 'combos'])->name('combos');
    Route::get('/productosFind', [App\Http\Controllers\ProductController::class, 'productosFind'])->name('productosFind');
    Route::get('/serviciosFind', [App\Http\Controllers\ProductController::class, 'serviciosFind'])->name('serviciosFind');
    Route::get('/productByName', [App\Http\Controllers\ProductController::class, 'productByName'])->name('productByName');

    Route::get('/combosFind', [App\Http\Controllers\ProductController::class, 'combosFind'])->name('combosFind');
    Route::post('/productosCreate', [App\Http\Controllers\ProductController::class, 'productosCreate'])->name('productosCreate');
    Route::post('/productosEdit', [App\Http\Controllers\ProductController::class, 'productosEdit'])->name('productosEdit');
    Route::post('/productosDetail', [App\Http\Controllers\ProductController::class, 'productosDetail'])->name('productosDetail');
    Route::post('/productosDel', [App\Http\Controllers\ProductController::class, 'productosDel'])->name('productosDel');
    Route::post('/destroyCombo', [App\Http\Controllers\ProductController::class, 'destroyCombo'])->name('destroyCombo');
    Route::post('/destroyServicio', [App\Http\Controllers\ProductController::class, 'destroyServicio'])->name('destroyServicio');
    Route::post('/desactivarProducto', [App\Http\Controllers\ProductController::class, 'desactivarProducto'])->name('desactivarProducto');
    Route::post('/removeComboProduct', [App\Http\Controllers\ProductController::class, 'removeComboProduct'])->name('removeComboProduct');
    Route::post('/searchNameProduct', [App\Http\Controllers\ProductController::class, 'searchNameProduct'])->name('searchNameProduct');
    Route::post('/searchNameServicio', [App\Http\Controllers\ProductController::class, 'searchNameServicio'])->name('searchNameServicio');
    Route::post('/searchNameCombo', [App\Http\Controllers\ProductController::class, 'searchNameCombo'])->name('searchNameCombo');
    Route::post('/findCatProduct', [App\Http\Controllers\ProductController::class, 'findCatProduct'])->name('findCatProduct');
    Route::post('/findCatService', [App\Http\Controllers\ProductController::class, 'findCatService'])->name('findCatService');
    Route::post('/findCatCombo', [App\Http\Controllers\ProductController::class, 'findCatCombo'])->name('findCatCombo');
    
    Route::post('/findProductByName', [App\Http\Controllers\ProductController::class, 'findProductByName'])->name('findProductByName');
    Route::post('/findProductByBarcode', [App\Http\Controllers\ProductController::class, 'findProductByBarcode'])->name('findProductByBarcode');

    // route resource facturacion
    Route::get('/facturacion', [App\Http\Controllers\FacturacionController::class, 'index'])->name('facturacion.index');
    Route::get('/checkCart', [App\Http\Controllers\FacturacionController::class, 'checkCart'])->name('checkCart');

    Route::post('/addToCart', [App\Http\Controllers\FacturacionController::class, 'addToCart'])->name('addToCart');
    Route::post('/plusCantidad', [App\Http\Controllers\FacturacionController::class, 'plusCantidad'])->name('plusCantidad');
    Route::post('/minusCantidad', [App\Http\Controllers\FacturacionController::class, 'minusCantidad'])->name('minusCantidad');
    Route::post('/deleteCurrentCart', [App\Http\Controllers\FacturacionController::class, 'deleteCurrentCart'])->name('deleteCurrentCart');
    Route::post('/changeQTY', [App\Http\Controllers\FacturacionController::class, 'changeQTY'])->name('changeQTY');
    Route::post('/deleteCart', [App\Http\Controllers\FacturacionController::class, 'deleteCart'])->name('deleteCart');
    Route::post('/impuestoGlobalCart', [App\Http\Controllers\FacturacionController::class, 'impuestoGlobalCart'])->name('impuestoGlobalCart');
    Route::post('/findCart', [App\Http\Controllers\FacturacionController::class, 'findCart'])->name('findCart');
    Route::post('/editProductCart', [App\Http\Controllers\FacturacionController::class, 'editProductCart'])->name('editProductCart');
    
    Route::get('/checkConfig', [App\Http\Controllers\FacturacionController::class, 'checkConfig'])->name('checkConfig');
    
});
