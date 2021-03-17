<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProveedorController extends Controller
{
    const MESSAGES = [
        'required' => 'El atributo :attribute es requerido.',
        'max' => 'El atributo :attribute  no puede exceder los :max caracteres',
        'min' => 'El atributo :attribute  no puede contener menos de los :min caracteres',
        'unique' => 'El atributo de :attribute ya existe',

    ];

    const CUSTOM_ATTRIBUTES = [
        'nombre' => 'Nombre',
        'direccion' => 'Direccion',
        'descripcion' => 'Descripcion',
        'telefono_ad' => 'Telefono'
    ];


    public function list()
    {
        $proveedor = Proveedor::all();
        return response()->json(['response' => ['status' => true, 'data' => $proveedor, 'message' => 'Query success']], 200);
    }

    public function add(Request $request)
    {
        try {
            $validar = Validator::make($request->data, [
                'proveedor_rut' => 'required|max:45|min:2',
                'proveedor_nombre' => 'required|max:45|min:2',
                'proveedor_apellido_paterno' => 'required|max:50|min:2',
                'proveedor_apellido_materno' => 'required|max:50|min:2',
                'proveedor_direccion' => 'required|max:50|min:2',
                'proveedor_telefono' => 'required|max:50|min:2',
                'proveedor_razon_social' => 'required|max:50|min:2',
                'proveedor_giro' => 'required|max:50|min:2',
                'proveedor_ciudad' => 'required|max:50|min:2',
                'proveedor_email' => 'required|max:50|min:2',

            ], ProveedorController::MESSAGES, ProveedorController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $proveedor = new Proveedor($request->data);
            $proveedor->save();


            return response()->json(['response' => ['status' => true, 'data' => $proveedor, 'message' => 'Proveedor Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = Validator::make($request->data, [
                'proveedor_rut' => 'required|max:20|min:2',
                'proveedor_nombre' => 'required|max:100|min:2',
                'proveedor_apellido_paterno' => 'max:100|min:2',
                'proveedor_apellido_materno' => 'max:100|min:2',
                'proveedor_direccion' => 'required|max:100|min:2',
                'proveedor_telefono' => 'required|max:50|min:2',
                'proveedor_razon_social' => 'required|max:200|min:2',
                'proveedor_giro' => 'required|max:100|min:2',
                'proveedor_ciudad' => 'max:50|min:2',
                'proveedor_email' => 'max:50|min:2',
            ], ProveedorController::MESSAGES, ProveedorController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $proyecto = Proveedor::find($id);
            $proyecto->proveedor_rut = $request->data['proveedor_rut'];
            $proyecto->proveedor_nombre = strtoupper($request->data['proveedor_nombre']);
            $proyecto->proveedor_apellido_paterno = strtoupper($request->data['proveedor_apellido_paterno']);
            $proyecto->proveedor_apellido_materno = strtoupper($request->data['proveedor_apellido_materno']);
            $proyecto->proveedor_direccion = strtoupper($request->data['proveedor_direccion']);
            $proyecto->proveedor_telefono = $request->data['proveedor_telefono'];
            $proyecto->proveedor_razon_social = strtoupper($request->data['proveedor_razon_social']);
            $proyecto->proveedor_giro = strtoupper($request->data['proveedor_giro']);
            $proyecto->proveedor_ciudad = strtoupper($request->data['proveedor_ciudad']);
            $proyecto->proveedor_email = strtoupper($request->data['proveedor_email']);
            $proyecto->save();


            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proveedor Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }
    public function delete($id)
    {
        try {
            $proveedor = Proveedor::find($id);
            $producto = Producto::where('proveedors_id', $id)->get();

            if (isset($producto)) {
                return response()->json(['response' => ['type_error' => 'entity_not_found', 'status' => false, 'data' => [], 'message' => 'Proveedor consultado no existe']], 400);
            }

            if ($proveedor->count() > 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No es posible eliminar el Proveedor " . $proveedor[0]['nombre'] . " ya que tiene Productos asociadas"]], 200);
            }

            $proveedor = Proveedor::where('id',$id);
            $proveedor->delete();

            return response()->json(['response' => ['status' => true, 'data' => $proveedor, 'message' => 'Proveedor Eliminado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 200);
        }
    }



}

