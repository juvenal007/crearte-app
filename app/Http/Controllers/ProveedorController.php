<?php

namespace App\Http\Controllers;

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
        $proveedor = DB::table('proveedors')->get();
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
            

            return response()->json(['response' => ['status' => true, 'data' => $proveedor, 'message' => 'Proyecto Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = Validator::make($request->data, [
                'nombre' => 'required|max:45|min:2|unique',
                'direccion' => 'required|max:50|min:2',
                'descripcion' => 'required|max:50|min:2',
                'telefono_ad' => 'required|max:15|min:8',
            ], ProyectoController::MESSAGES, ProyectoController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $proyecto = Proyecto::find($id);
            $proyecto->nombre = $request->data['nombre'];
            $proyecto->direccion = $request->data['direccion'];
            $proyecto->descripcion = $request->data['descripcion'];
            $proyecto->telefono_ad = $request->data['telefon_ad'];
            $proyecto->save();

            //DEVELOP BRANCH


            return response()->json(['response' => ['status' => true, 'data' => $proyecto, 'message' => 'Proyecto Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }

  
}

