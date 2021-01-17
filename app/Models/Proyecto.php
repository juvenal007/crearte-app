<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proyecto extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'proyectos';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'proyecto_nombre',
        'proyecto_direccion',
        'proyecto_descripcion',
        'proyecto_telefono_ad',
        'proyecto_centro_costo_id',
        'proyecto_estado_id'
    ];

    //RELACIÓN DIRECTA HACIA CENTRO DE COSTOS
    public function centro_costo()
    {
        return $this->belongsTo('App\Models\CentroCosto', 'proyecto_centro_costo_id');
    }

    //RELACIÓN DIRECTA HACIA CLIENTE
    public function estado()
    {
        return $this->belongsTo('App\Models\Estado', 'proyecto_estado_id');
    }
    public function detalle_solicituds()
    {
        return $this->hasMany('App\Models\DetalleSolicitud');
    }
    public function clientes()
    {
        return $this->hasMany('App\Models\Cliente');
    }
}
