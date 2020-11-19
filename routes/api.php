<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CentroCostoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProyectoController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::group(['middleware' => ['jwt.verify']], function() {

    // ESTADOS
    Route::get('/estado/list', [EstadoController::class, 'list']);

    // CENTRO DE COSTOS
    Route::get('/centro-costo/list', [CentroCostoController::class, 'list']);
    Route::get('/centro-costo/details/{id}', [CentroCostoController::class, 'details']);
    Route::post('/centro-costo/store', [CentroCostoController::class, 'add']);
    Route::put('/centro-costo/update/{id}', [CentroCostoController::class, 'edit']);
    Route::delete('/centro-costo/delete/{id}', [CentroCostoController::class, 'delete']);
    Route::get('/centro-costo/pluck', [CentroCostoController::class, 'pluck']);


    // PROVEEDORES
    Route::get('/proveedor/list', [ProveedorController::class, 'list']);
    Route::get('/proveedor/details/{id}', [CProveedorontroller::class, 'details']);
    Route::post('/proveedor/store', [ProveedorController::class, 'add']);
    Route::put('/proveedor/update/{id}', [ProveedorController::class, 'edit']);
    Route::delete('/proveedor/delete/{id}', [ProveedorController::class, 'delete']);
    Route::get('/proveedor/pluck', [ProveedorController::class, 'pluck']);
    
    
    // PROYECTOS
    Route::get('/proyecto/list/{centro_costo_id}', [ProyectoController::class, 'list']);
    Route::get('/proyecto/details/{id}', [ProyectoController::class, 'details']);
    Route::post('/proyecto/store/', [ProyectoController::class, 'add']);
    Route::put('/proyecto/update/{id}', [ProyectoController::class, 'edit']);
    Route::delete('/proyecto/delete/{id}', [ProyectoController::class, 'delete']);
    Route::get('/proyecto/pluck', [ProyectoController::class, 'pluck']);
    Route::post('/proyecto/add_cliente/{id}', [ProyectoController::class, 'add_cliente']);


    // CLIENTES
    Route::get('/cliente/list/', [ClienteController::class, 'list']);
    Route::get('/cliente/details/{id}', [ClienteController::class, 'details']);
    Route::get('/cliente/proyecto_details/{id}', [ClienteController::class, 'proyecto_details']);
    Route::post('/cliente/store/', [ClienteController::class, 'add']);
    Route::put('/cliente/update/{id}', [ClienteController::class, 'edit']);    
    Route::delete('/cliente/delete/{id}', [ClienteController::class, 'delete']);
    Route::get('/cliente/pluck', [ClienteController::class, 'pluck']);

    // PRODUCTOS
    Route::get('/producto/list/', [ProductoController::class, 'list']);
    Route::get('/producto/details/{id}', [ProductoController::class, 'details']);
    Route::get('/producto/proyecto_details/{id}', [ProductoController::class, 'proyecto_details']);
    Route::post('/producto/store/', [ProductoController::class, 'add']);
    Route::put('/producto/update/{id}', [ProductoController::class, 'edit']);    
    Route::delete('/producto/delete/{id}', [ProductoController::class, 'delete']);
    Route::get('/producto/pluck', [ProductoController::class, 'pluck']);
});
