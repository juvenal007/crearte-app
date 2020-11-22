<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogoController extends Controller
{
    public function list()
    {
        $catalogos = DB::table('catalogos')->get();
        return response()->json(['response' => ['status' => true, 'data' => $catalogos, 'message' => 'Query success']], 200);
    }
}
