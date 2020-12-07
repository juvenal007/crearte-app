<?php

namespace App\Http\Controllers;

use App\Models\Catalogo;
use App\Models\Proyecto;
use App\Models\SolicitudCatalogo;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogoController extends Controller
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
        $catalogos = Catalogo::all();
        return response()->json(['response' => ['status' => true, 'data' => $catalogos, 'message' => 'Query success']], 200);
    }

    

    // ID DE SOLICITUD
    public function details($id)
    {
        $catalogos = SolicitudCatalogo::with('catalogos')->where('solicituds_id', $id)->get();
        return response()->json(['response' => ['status' => true, 'data' => $catalogos, 'message' => 'Query success']], 200);
    }

    public function add(Request $request)
    {
        try {
            $validar = Validator::make($request->data, [
                'catalogo_material' => 'required|max:45|min:2',
                'catalogo_descripcion' => 'required|max:50|min:2',
                'catalogo_unidad' => 'required|max:50|min:2',           

            ], CatalogoController::MESSAGES, CatalogoController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }
           
            $catalogo = new Catalogo($request->data);
            $catalogo->save();            

            return response()->json(['response' => ['status' => true, 'data' => $catalogo, 'message' => 'Producto Catalogo Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = Validator::make($request->data, [
                'catalogo_material' => 'required|max:45|min:2',
                'catalogo_descripcion' => 'required|max:50|min:2',
                'catalogo_unidad' => 'required|max:50|min:2',               
            ], CatalogoController::MESSAGES, CatalogoController::CUSTOM_ATTRIBUTES);
            if ($validar->fails()) {
                return response()->json(['response' => ['type_error' => 'validation_error', 'status' => false, 'data' => $validar->errors(), 'message' => 'Validation errors']], 200);
            }

            $catalogo = Catalogo::find($id);
            $catalogo->catalogo_material = $request->data['catalogo_material'];
            $catalogo->catalogo_descripcion = $request->data['catalogo_descripcion'];
            $catalogo->catalogo_unidad = $request->data['catalogo_unidad'];      
            $catalogo->save();

            //DEVELOP BRANCH


            return response()->json(['response' => ['status' => true, 'data' => $catalogo, 'message' => 'Catalogo Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $error) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $error, 'message' => 'Error processing']], 500);
        }
    }

    
    public function delete($id)
    {
        try {
            $catalogo = SolicitudCatalogo::where('catalogos_id', $id)->get();

            if (!$catalogo) {
                return response()->json(['response' => ['type_error' => 'entity_not_found', 'status' => false, 'data' => [], 'message' => 'Catalogo consultado no existe']], 400);
            }

            if ($catalogo->count() > 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No es posible eliminar el Producto " . $catalogo[0]['descripcion'] . " ya que tiene Solicitudes asociadas"]], 200);
            }

            $catalogo = Catalogo::where('id',$id);
            $catalogo->delete();

            return response()->json(['response' => ['status' => true, 'data' => $catalogo, 'message' => 'Producto Catalogo Eliminado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 200);
        }
    }
}
