<?php namespace App\Repositories\Eloquent;



abstract class CentroCostoModel 
{
  
    public static function findRepoModel($object, $id)
    {
        return $object::find($id);
    }

    public static function createRepoModel($object)
    {         
        return $object->save();
    }
}