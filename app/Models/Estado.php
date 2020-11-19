<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'estados';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at']; 

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'estado',
        'estado_descripcion',
        'estados_id'
    ];

    //RELACIÓN INVERSA HACIA CENTRO DE COSTOS
    public function proyectos()
    {
        return $this->hasMany('App\Models\Proyecto', 'centro_costos_id');
    }

    //RELACION INVERSA HACIA SOLICITUDS
    public function solicituds()
    {
        return $this->hasMany('App\Models\Solicitud', 'estados_id');
    }
}