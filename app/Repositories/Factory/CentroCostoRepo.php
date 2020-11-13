<?php namespace App\Repositories\Factory;

use App\Models\CentroCosto;
use App\Repositories\Eloquent\CentroCostoModel;
use App\Repositories\Contracts\CentroCostoRepoInterface;


class CentroCostoRepo extends CentroCostoModel implements CentroCostoRepoInterface
{
    protected $object;
    protected $selftClass = CentroCosto::class;
    
    public function __construct(CentroCosto $object)
    {
        $this->object = $object;
    }

    public function find($id)
    {
        return CentroCostoModel::findRepoModel($this->object, $id);
    }

    public function create($object)
    {             
        return CentroCostoModel::createRepoModel($object);  
    }
}