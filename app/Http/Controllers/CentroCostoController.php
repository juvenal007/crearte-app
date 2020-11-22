<?php

namespace App\Http\Controllers;

use App\Models\CentroCosto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\JsonResponse\Contracts\ListResponseInterface;
use App\Validate\CentroCostoValidate;
use App\Factory\Contracts\CreateCentroCostoInterface;
use App\Repositories\Factory\CentroCostoRepo;



class CentroCostoController extends Controller
{
    const MESSAGES = [
        'required' => 'El atributo :attribute es requerido.',
        'max' => 'El atributo :attribute  no puede exceder los :max caracteres',
        'min' => 'El atributo :attribute  no puede contener menos de los :min caracteres',
        'unique' => 'El atributo de :attribute ya existe',

    ];

    const CUSTOM_ATTRIBUTES = [
        'nombre' => 'Nombre',
        'direccion' => 'Direccion'
    ];

    public function __construct(ListResponseInterface $ListResponse, CreateCentroCostoInterface $CreateCentroCosto, CentroCostoRepo $CentroCostoRepo, CentroCostoValidate $CentroCostoValidate)
    {
        $this->ListResponse = $ListResponse;
        $this->Create = $CreateCentroCosto;
        $this->Repo = $CentroCostoRepo;
        $this->Validate = $CentroCostoValidate;
    }

    public function list()
    {
        $centro_costos = DB::table('centro_costos')->get();
        return response()->json(['response' => ['status' => true, 'data' => $centro_costos, 'message' => 'Query success']], 200);
    }

    public function add(Request $request)
    {
        try {
            $validar = CentroCostoValidate::validateAdd($request);
            if (!$validar->getData()->response->status) {
                return json_encode($validar->getData());
            }
            $centroCosto = $this->Create->createObject($request);
            $centroCosto = $this->Repo->create($centroCosto);
            return response()->json(['response' => ['status' => true, 'data' => $centroCosto, 'message' => 'Centro de Costos Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = CentroCostoValidate::validateAdd($request);
        if (!$validar->getData()->response->status) {
            return json_encode($validar->getData());
        }
        $centroCosto = CentroCosto::find($id);
        $centroCosto->nombre = $request->data['nombre'];
        $centroCosto->direccion = $request->data['direccion'];
        $centroCosto->save();

        return response()->json(['response' => ['status' => true,'data' => $centroCosto,'message' => 'Centro de Costos Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
        
    }

    public function details($id)
    {
        $centro_costos = CentroCosto::Where('id', $id)->get();        
        return response()->json(['response' => ['status' => true,'data' => $centro_costos,'message' => 'Centro de Costos Obtenido']], 200);
    }
}
