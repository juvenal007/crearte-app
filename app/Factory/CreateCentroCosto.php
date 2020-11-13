<?php

namespace App\Factory;


use App\Models\CentroCosto;
use App\Factory\Contracts\CreateCentroCostoInterface;

class CreateCentroCosto implements CreateCentroCostoInterface
{     
    public function __construct(CentroCosto $CentroCosto)
    {
        $this->CentroCosto = $CentroCosto;
    } 
    public function createObject($request)
    {
        $object = New $this->CentroCosto($request->data);     
        return $object;
    }
}
