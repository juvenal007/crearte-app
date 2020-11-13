<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CentroCostoController;
use App\Http\Controllers\ProyectoController;
use Illuminate\Http\Request;
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


    // CENTRO DE COSTOS
    Route::get('/centro-costo/list', [CentroCostoController::class, 'list']);
    Route::get('/centro-costo/details/{id}', [CentroCostoController::class, 'details']);
    Route::post('/centro-costo/store', [CentroCostoController::class, 'add']);
    Route::put('/centro-costo/update/{id}', [CentroCostoController::class, 'edit']);
    Route::delete('/centro-costo/delete/{id}', [CentroCostoController::class, 'delete']);
    Route::get('/centro-costo/pluck', [CentroCostoController::class, 'pluck']);
    
    
    // PROYECTOS
    Route::get('/proyecto/list/{centro_costo_id}', [ProyectoController::class, 'list']);
    Route::get('/proyecto/details/{id}', [ProyectoController::class, 'details']);
    Route::post('/proyecto/store/{centro_costo_id}', [ProyectoController::class, 'add']);
    Route::put('/proyecto/update/{id}', [ProyectoController::class, 'edit']);
    Route::delete('/proyecto/delete/{id}', [ProyectoController::class, 'delete']);
    Route::get('/proyecto/pluck', [ProyectoController::class, 'pluck']);
});
