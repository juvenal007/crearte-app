<?php namespace App\Repositories\Contracts;

//CREAR INTERFACE REPOSITORIO
interface CentroCostoRepoInterface
{
    public function find($id);
    public function create($object);
}