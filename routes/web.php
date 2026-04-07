<?php

use App\Http\Controllers\abmController;
use App\Http\Controllers\CategoriaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UserController;
use App\Models\Producto;
use App\Http\Controllers\ContactController;

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

/* ROUTE CONTACTO */
Route::post('/contacto', [ContactController::class, 'sendEmail'])->name('contacto.send');

/* ROUTES CATEGORIAS */
Route::get('/categorias', [CategoriaController::class,  'index_cat'])->name('index_cat');
// Deprecated
Route::get('/categorias/{id}/productos', [ProductoController::class, 'productosPorCategoria'])->name('productos_por_categoria');

/* ABM CATEGORIAS */
Route::middleware([\App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    Route::get('/admin/categorias', [CategoriaController::class, 'adminIndex'])->name('admin.categorias');
    Route::get('/admin/categorias/create', [CategoriaController::class, 'create'])->name('admin.categorias.create');
    Route::get('/admin/categorias/{id}/edit', [CategoriaController::class, 'edit'])->name('admin.categorias.edit');
    Route::post('/admin/categorias', [CategoriaController::class, 'store'])->name('admin.categorias.store');
    Route::put('/admin/categorias/{id}', [CategoriaController::class, 'update'])->name('admin.categorias.update');
    Route::delete('/admin/categorias/{id}', [CategoriaController::class, 'destroy'])->name('admin.categorias.destroy');
    Route::get('/admin/categorias/export/excel', [CategoriaController::class, 'exportExcel'])->name('admin.categorias.export.excel');
    Route::get('/admin/categorias/export/pdf', [CategoriaController::class, 'exportPDF'])->name('admin.categorias.export.pdf');
    Route::get('/admin/categorias/export/csv', [CategoriaController::class, 'exportCSV'])->name('admin.categorias.export.csv');
});


/* ROUTES PRODUCTO */
//Route::resource("producto", ProductoController::class);

Route::middleware([\App\Http\Middleware\CheckRole::class . ':admin'])->group(function () {
    // Exportar productos
    Route::get('/admin/productos/export/excel', [ProductoController::class, 'exportExcel'])->name('admin.productos.export.excel');
    Route::get('/admin/productos/export/pdf', [ProductoController::class, 'exportPDF'])->name('admin.productos.export.pdf');
    Route::get('/admin/productos/export/csv', [ProductoController::class, 'exportCSV'])->name('admin.productos.export.csv');

    // Gestión de productos
    Route::get('/admin/productos/{id}/edit', [ProductoController::class, 'edit'])->name('admin.productos.edit');
    Route::put('/admin/productos/{id}', [ProductoController::class, 'update'])->name('admin.productos.update');
    Route::delete('/admin/productos/{id}', [ProductoController::class, 'destroy'])->name('admin.productos.destroy');

    // Crear y almacenar productos
    Route::get('/admin/productos/create', [ProductoController::class, 'create'])->name('admin.productos.create');
    Route::post('/admin/productos', [ProductoController::class, 'store'])->name('admin.productos.store');

    // Índice de productos
    Route::get('/admin/productos', [ProductoController::class, 'admin_productos_index'])->name('admin.productos');
});

Route::get('/', [ProductoController::class, 'index'])->name('welcome'); //indice vista inicial

Route::get('/search', [ProductoController::class, 'search'])->name('search_products');

Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('producto.show');

/* ROUTES DE LOGIN */

Route::get('/user-log/login', [UserController::class, 'r_view_login_remake'])->name('user-log.r_view_login_remake');

Route::get('/user-log/register', [UserController::class, 'r_view_register_remake'])->name('user-log.r_view_register_remake');

Route::get('/user-log/olvidar_contrasena', [UserController::class, 'olvidar_contrasena'])->name('user-log.olvidar_contrasena');

Route::get('/user-log/restaurar_password', [UserController::class, 'restaurar_password'])->name('user-log.restaurar_password');
Route::post('/user-log/restaurar_password', [UserController::class, 'restaurar_password'])->name('user-log.restaurar_password');

// Route::get('/user-log/verificar_codigo/{usuario}', [UserController::class, 'ingresar_codigo'])->name('user-log.verificar_codigo');

Route::post('/user-log/verificar_codigo/{usuario}', [UserController::class, 'verificar_codigo'])->name('user-log.verificar_codigo');

// El GET lo necesito para el reenviar codigo
Route::get('/user-log/verificar_codigo/{usuario}', [UserController::class, 'verificar_codigo'])->name('user-log.verificar_codigo');

Route::get('/user-log/ingresar_codigo/{usuario}', [UserController::class, 'ingresar_codigo'])->name('user-log.ingresar_codigo');

Route::get('/user-log/set-new-password/{usuario}', [UserController::class, 'showSetNewPasswordForm'])->name('user-log.set_new_password');

Route::post('/user-log/set-new-password/{usuario}', [UserController::class, 'setNewPassword'])->name('user-log.set_new_password');

/* ACLARACION : Aca podria poner una ruta directa para el reenvio, pero la anido ya que por ahora solo esta asociado al login */

Route::get('/user-log/verificar_codigo/reenvio/{usuario}', [UserController::class, 'reenviarCodigo'])->name('user-log.reenviar_codigo');


// Tambien tiene sentido que esto hubiera sido un post-login
Route::post('/user-log/authenticate', [UserController::class, 'authenticate'])->name('user-log.authenticate');

Route::post('/user-log/register', [UserController::class, 'register'])->name('user-log.register_remake');

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

/* ROUTES DE ADMIN */
Route::get('/admin/welcome', [UserController::class, 'index_abm'])->name('admin.welcome-admin');

// Enrutamiento view about-us
Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

// Enrutamiento abm
Route::get('/abm', function () {
    return view('admin.abm-list');
})->name('admin.abm-list');
