<?php

namespace App\Http\Controllers;

use App\Models\CentroCosto;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\JsonResponse\Contracts\ListResponseInterface;
use App\Validate\CentroCostoValidate;
use App\Factory\Contracts\CreateCentroCostoInterface;
use App\Models\DetalleSolicitud;
use App\Models\Estado;
use App\Models\Proyecto;
use App\Repositories\Factory\CentroCostoRepo;
use Illuminate\Support\Facades\Validator;


class CentroCostoController extends Controller
{
    const MESSAGES = [
        'required' => 'El atributo :attribute es requerido.',
        'max' => 'El atributo :attribute  no puede exceder los :max caracteres',
        'min' => 'El atributo :attribute  no puede contener menos de los :min caracteres',
        'unique' => 'El atributo de :attribute ya existe',

    ];

    const CUSTOM_ATTRIBUTES = [
        'cc_nombre' => 'Nombre',
        'cc_direccion' => 'Direccion'
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
        $centro_costos = CentroCosto::all();
        return response()->json(['response' => ['status' => true, 'data' => $centro_costos, 'message' => 'Query success']], 200);
    }

    public function list_activo()
    {
        try {
            $estado = Estado::where('estado', 'CENTRO_COSTO_ACTIVO')->first();
            $centroCosto = CentroCosto::where('cc_estado_id', $estado->id)->get();
            if ($centroCosto->count() <= 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No se encontraron clientes"]], 404);
            }
            return response()->json(['response' => ['status' => true, 'data' => $centroCosto, 'message' => 'Query success']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
        // ID DEL ESTADO ES 10 SIGNIFICA QUE ESTÁ ACTIVO
    }

    public function add(Request $request)
    {
        try {
            /*  $validar = CentroCostoValidate::validateAdd($request);
            if (!$validar->getData()->response->status) {
                return json_encode($validar->getData());
            } */
            DB::beginTransaction();

            $estado = Estado::where('estado', 'CENTRO_COSTO_ACTIVO')->first();

            $centroCosto = new CentroCosto();
            $centroCosto->cc_nombre = strtoupper($request->data['cc_nombre']);
            $centroCosto->cc_direccion = strtoupper($request->data['cc_direccion']);
            $centroCosto->cc_estado_id = $estado->id;
            $centroCosto->save();

            $centroCostoUltimo = CentroCosto::orderBy('created_at', 'DESC')->take(1)->get();

            $datos = [
                'ds_centro_costo_id' => $centroCostoUltimo[0]->id,
                'ds_proyecto_id' => NULL,
                'ds_cliente_id' => NULL
            ];

            $detalle_solicitud = new DetalleSolicitud($datos);
            $detalle_solicitud->save();

            DB::commit();
            return response()->json(['response' => ['status' => true, 'data' => $centroCosto, 'message' => 'Centro de Costos Creado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $validar = Validator::make($request->data, [
                'cc_nombre' => 'required|max:100|min:2',
                'cc_direccion' => 'required|max:200|min:2'
            ], CentroCostoController::MESSAGES, CentroCostoController::CUSTOM_ATTRIBUTES);

            $centroCosto = CentroCosto::find($id);
            $centroCosto->cc_nombre = strtoupper($request->data['cc_nombre']);
            $centroCosto->cc_direccion = strtoupper($request->data['cc_direccion']);
            $centroCosto->save();

            return response()->json(['response' => ['status' => true, 'data' => $centroCosto, 'message' => 'Centro de Costos Actualizado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 500);
        }
    }

    public function details($id)
    {
        $centro_costos = CentroCosto::Where('id', $id)->get();
        return response()->json(['response' => ['status' => true, 'data' => $centro_costos, 'message' => 'Centro de Costos Obtenido']], 200);
    }

    public function delete($id)
    {
        try {
            $centro_costos = CentroCosto::find($id);
            $proyecto = Proyecto::where('proyecto_centro_costo_id', $id)->get();

            if (!isset($centro_costos)) {
                return response()->json(['response' => ['type_error' => 'entity_not_found', 'status' => false, 'data' => [], 'message' => 'Centro de Costo consultado no existe']], 400);
            }

            if ($proyecto->count() > 0) {
                return response()->json(['response' => ['type_error' => 'not_allowed', 'status' => false, 'data' => [], 'message' => "No es posible eliminar el Centro de Costo " . $centro_costos['cc_nombre'] . " ya que tiene proyectos asociados"]], 200);
            }

            $centro_costos->delete();

            return response()->json(['response' => ['status' => true, 'data' => $centro_costos, 'message' => 'Centro de Costo Eliminado']], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['response' => ['type_error' => 'query_exception', 'status' => false, 'data' => $e, 'message' => 'Error processing']], 200);
        }
    }
}
