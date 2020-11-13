<?php

namespace App\JsonResponse;

use App\JsonResponse\Contracts\ListResponseInterface;



class ListResponse implements ListResponseInterface
{
    public function JsonResponse($request)
    {
        return response()->json(['response' => ['status' => true, 'data' => $request, 'msg' => 'Query success']], 200);
    }
}
