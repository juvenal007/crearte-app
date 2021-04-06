<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BodegaProductoController;
use App\Http\Controllers\CatalogoController;
use App\Http\Controllers\CentroCostoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\EstadoController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\OrdenCompraController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\SalidaController;
use App\Http\Controllers\SalidaProductoController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\TipoSolicitudController;
use App\Http\Controllers\UnidadController;
use App\Models\BodegaProducto;
use App\Models\Solicitud;
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
Route::post('logout', [AuthController::class, 'logout']);

Route::get('/generar-pdf', [SolicitudController::class, 'generatePDF']);

Route::group(['middleware' => ['jwt.verify']], function () {



    // ESTADOS
    Route::get('/estado/list', [EstadoController::class, 'list']);

    // SALIDA PRODUCTOS
    Route::get('/salida-producto/list/{idCliente}', [SalidaProductoController::class, 'list']);

    // COSTO PROYECTO
    Route::get('/proyecto/list/costo/{idProyecto}', [ProyectoController::class, 'costo_proyecto']);




    // EGRESO
    Route::get('/salida/list', [SalidaController::class, 'list']);
    Route::get('/salida/details/{id}', [SalidaController::class, 'details']);
    Route::post('/salida/store', [SalidaController::class, 'add']);
    Route::put('/salida/update/{id}', [SalidaController::class, 'edit']);
    Route::delete('/salida/delete/{id}', [SalidaController::class, 'delete']);
    Route::get('/salida/pluck', [SalidaController::class, 'pluck']);

    //BODEGA PRODUCTOS
    Route::get('/bodega-producto/list_all', [BodegaProductoController::class, 'list_all']);
    Route::get('/bodega-producto/producto-bodega/{idCliente}', [BodegaProductoController::class, 'getProductosBodega']);
    Route::get('/bodega-producto/details/{id}', [BodegaProductoController::class, 'details']);
    Route::post('/bodega-producto/store', [BodegaProductoController::class, 'add']);
    Route::put('/bodega-producto/update/{id}', [BodegaProductoController::class, 'edit']);
    Route::delete('/bodega-producto/delete/{id}', [BodegaProductoController::class, 'delete']);
    Route::get('/bodega-producto/pluck', [BodegaProductoController::class, 'pluck']);

    // CENTRO DE COSTOS
    Route::get('/centro-costo/list', [CentroCostoController::class, 'list']);
    Route::get('/centro-costo/list_activo', [CentroCostoController::class, 'list_activo']);
    Route::get('/centro-costo/details/{id}', [CentroCostoController::class, 'details']);
    Route::post('/centro-costo/store', [CentroCostoController::class, 'add']);
    Route::put('/centro-costo/update/{id}', [CentroCostoController::class, 'edit']);
    Route::delete('/centro-costo/delete/{id}', [CentroCostoController::class, 'delete']);
    Route::get('/centro-costo/pluck', [CentroCostoController::class, 'pluck']);


    // PROVEEDORES
    Route::get('/proveedor/list', [ProveedorController::class, 'list']);
    Route::get('/proveedor/details/{id}', [ProveedorController::class, 'details']);
    Route::post('/proveedor/store', [ProveedorController::class, 'add']);
    Route::put('/proveedor/update/{id}', [ProveedorController::class, 'edit']);
    Route::delete('/proveedor/delete/{id}', [ProveedorController::class, 'delete']);
    Route::get('/proveedor/pluck', [ProveedorController::class, 'pluck']);


    // PROYECTOS
    Route::get('/proyecto/list/{centro_costo_id}', [ProyectoController::class, 'list']);
    Route::get('/proyecto/list_activo/', [ProyectoController::class, 'list_activo']);
    Route::get('/proyecto/details/{id}', [ProyectoController::class, 'details']);
    Route::post('/proyecto/store/{centro_costo_id}', [ProyectoController::class, 'add']);
    Route::put('/proyecto/update/{id}', [ProyectoController::class, 'edit']);
    Route::delete('/proyecto/delete/{id}', [ProyectoController::class, 'delete']);
    Route::get('/proyecto/pluck', [ProyectoController::class, 'pluck']);
    Route::post('/proyecto/add_cliente/{id}', [ProyectoController::class, 'add_cliente']);


    // CLIENTES
    Route::get('/cliente/list/', [ClienteController::class, 'list']);
    Route::get('/cliente/list_activo/', [ClienteController::class, 'list_activo']);
    Route::get('/cliente/list_cliente_proyecto/{cliente_proyecto}', [ClienteController::class, 'list_cliente_proyecto']);
    Route::get('/cliente/details/{id}', [ClienteController::class, 'details']);
    Route::get('/cliente/proyecto_details/{id}', [ClienteController::class, 'proyecto_details']);
    Route::post('/cliente/store/', [ClienteController::class, 'add']);
    Route::put('/cliente/update/{id}', [ClienteController::class, 'edit']);
    Route::delete('/cliente/delete/{id}', [ClienteController::class, 'delete']);
    Route::get('/cliente/pluck', [ClienteController::class, 'pluck']);

    // PRODUCTOS
    Route::get('/producto/list/', [ProductoController::class, 'list']);
    Route::get('/producto/list_all/', [ProductoController::class, 'list_all']);
    Route::get('/producto/details/{id}', [ProductoController::class, 'details']);
    Route::get('/producto/proyecto_details/{id}', [ProductoController::class, 'proyecto_details']);
    Route::post('/producto/store/', [ProductoController::class, 'add']);
    Route::put('/producto/update/{id}', [ProductoController::class, 'edit']);
    Route::delete('/producto/delete/{id}', [ProductoController::class, 'delete']);
    Route::get('/producto/pluck', [ProductoController::class, 'pluck']);

    // CATALOGOS
    Route::get('/catalogo/list/', [CatalogoController::class, 'list']);
    Route::get('/catalogo/details/{id}', [CatalogoController::class, 'details']);
    Route::get('/catalogo/details_unico/{id}', [CatalogoController::class, 'details_unico']);
    Route::post('/catalogo/store/', [CatalogoController::class, 'add']);
    Route::put('/catalogo/update/{id}', [CatalogoController::class, 'edit']);
    Route::delete('/catalogo/delete/{id}', [CatalogoController::class, 'delete']);
    Route::get('/catalogo/pluck', [CatalogoController::class, 'pluck']);

    // SOLICITUD
    Route::get('/solicitud/list/', [SolicitudController::class, 'list']);
    Route::get('/solicitud/list_all/', [SolicitudController::class, 'list_all']);
    Route::get('/solicitud/list/all', [SolicitudController::class, 'all']);
    Route::get('/solicitud/list/all_activa', [SolicitudController::class, 'all_activa']);
    Route::get('/solicitud/details/{id}', [SolicitudController::class, 'details']);
    Route::get('/solicitud/details_carro/{id}', [SolicitudController::class, 'details_carro']);
    Route::post('/solicitud/store/', [SolicitudController::class, 'add']);
    Route::put('/solicitud/update/{id}', [SolicitudController::class, 'edit']);
    Route::delete('/solicitud/delete/{id}', [SolicitudController::class, 'delete']);
    Route::get('/solicitud/pluck', [SolicitudController::class, 'pluck']);

    // TIPO SOLICITUD
    Route::get('/tipo-solicitud/list/', [TipoSolicitudController::class, 'list']);
    Route::get('/tipo-solicitud/list/all', [TipoSolicitudController::class, 'all']);
    Route::get('/tipo-solicitud/details/{id}', [TipoSolicitudController::class, 'details']);
    Route::post('/tipo-solicitud/store/', [TipoSolicitudController::class, 'add']);
    Route::put('/tipo-solicitud/update/{id}', [TipoSolicitudController::class, 'edit']);
    Route::delete('/tipo-solicitud/delete/{id}', [TipoSolicitudController::class, 'delete']);
    Route::get('/tipo-solicitud/pluck', [TipoSolicitudController::class, 'pluck']);

    // UNIDAD
    Route::get('/unidad/list/', [UnidadController::class, 'list']);
    Route::get('/unidad/list/all', [UnidadController::class, 'all']);
    Route::get('/unidad/details/{id}', [UnidadController::class, 'details']);
    Route::post('/unidad/store/', [UnidadController::class, 'add']);
    Route::put('/unidad/update/{id}', [UnidadController::class, 'edit']);
    Route::delete('/unidad/delete/{id}', [UnidadController::class, 'delete']);
    Route::get('/unidad/pluck', [UnidadController::class, 'pluck']);

    // COTIZACIÓN
    Route::get('/cotizacion/list/', [CotizacionController::class, 'list']);
    Route::get('/cotizacion/list/all', [CotizacionController::class, 'all']);
    Route::get('/cotizacion/details/{id}', [CotizacionController::class, 'details']);
    Route::post('/cotizacion/store/', [CotizacionController::class, 'add']);
    Route::put('/cotizacion/update/{id}', [CotizacionController::class, 'edit']);
    Route::delete('/cotizacion/delete/{id}', [CotizacionController::class, 'delete']);
    Route::get('/cotizacion/pluck', [CotizacionController::class, 'pluck']);

    // ORDEN COMPRA
    Route::get('/orden-compra/list/', [OrdenCompraController::class, 'list']);
    Route::get('/orden-compra/list/all', [OrdenCompraController::class, 'all']);
    Route::get('/orden-compra/list/all_activa', [OrdenCompraController::class, 'all_activa']);
    Route::get('/orden-compra/list/all_terminada', [OrdenCompraController::class, 'all_terminada']);
    Route::get('/orden-compra/details/{id}', [OrdenCompraController::class, 'details']);
    Route::get('/orden-compra/details_carro/{id}', [OrdenCompraController::class, 'details_carro']);
    Route::post('/orden-compra/store/', [OrdenCompraController::class, 'add']);
    Route::put('/orden-compra/update/{id}', [OrdenCompraController::class, 'edit']);
    Route::delete('/orden-compra/delete/{id}', [OrdenCompraController::class, 'delete']);
    Route::get('/orden-compra/pluck', [OrdenCompraController::class, 'pluck']);

    // INGRESO
    Route::get('/ingreso/list/', [IngresoController::class, 'list']);
    Route::get('/ingreso/list/all', [IngresoController::class, 'all']);
    Route::get('/ingreso/details/{id}', [IngresoController::class, 'details']);
    Route::post('/ingreso/store/', [IngresoController::class, 'add']);
    Route::put('/ingreso/update/{id}', [IngresoController::class, 'edit']);
    Route::delete('/ingreso/delete/{id}', [nController::class, 'delete']);
    Route::get('/ingreso/pluck', [IngresoController::class, 'pluck']);
});
