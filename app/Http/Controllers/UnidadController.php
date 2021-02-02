<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use App\Models\Producto;
use App\Models\Unidad;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    const MESSAGES = [
        'required' => 'El atributo :attribute es requerido.',
        'max' => 'El atributo :attribute  no puede exceder los :max caracteres',
        'min' => 'El atributo :attribute  no puede contener menos de los :min caracteres',
        'unique' => 'El atributo de :attribute ya existe',

    ];

    const CUSTOM_ATTRIBUTES = [
        'unidad_nombre' => 'Nombre',
        'unidad_descripcion' => 'Descripcion'
    ];
    public function list()
    {
        try {

            $unidad = Unidad::all();
            if ($unidad->count() <= 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No se encontraron unidades"]], 404);
            }
            return response()->json(['response' => ['status' => true, 'data' => $unidad, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }
    public function add(Request $request)
    {
        try {
            $validar = Validator::make($request->data, [
                'unidad_nombre' => 'required|max:100|min:2',
                'unidad_descripcion' => 'max:200|min:2'
            ], UnidadController::MESSAGES, UnidadController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $data = [
                'unidad_nombre' => strtoupper($request->data['unidad_nombre']),
                'unidad_descripcion' => strtoupper($request->data['unidad_descripcion']),
            ];

            $unidad = new Unidad($data);
            $unidad->save();
            return response()->json(['response' => ['status' => true, 'data' => $unidad, 'message' => 'Unidad Creada']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = Validator::make($request->data, [
                'unidad_nombre' => 'required|max:100|min:2',
                'unidad_descripcion' => 'max:200|min:2'
            ], UnidadController::MESSAGES, UnidadController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $unidad = Unidad::find($id);
            $unidad->unidad_nombre = strtoupper($request->data['unidad_nombre']);
            $unidad->unidad_descripcion = strtoupper($request->data['unidad_descripcion']);
            $unidad->save();

            return response()->json(['response' => ['status' => true, 'data' => $unidad, 'message' => 'Unidad Editada']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function delete($id)
    {
        try {
            $unidad = Unidad::find($id);
            $catalogo = Catalogo::where('catalogo_unidad_id',$id);
            $producto = Producto::where('producto_unidad_id',$id);

            if (!$unidad) {
                return response()->json(['response' => ['type_error' => 'entity_not_found', 'status' => false, 'data' => [], 'message' => 'Unidad consultado no existe']], 400);
            }

            if ($catalogo->count() > 0 || $producto->count() > 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No es posible eliminar la unidad " . $unidad['unidad_nombre'] . " ya que tiene Productos asociadas"]], 200);
            }

            $unidad = Unidad::find($id);
            $unidad->delete();

            return response()->json(['response' => ['status' => true, 'data' => $unidad, 'message' => 'Unidad Eliminada']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 200);
        }
    }
}
