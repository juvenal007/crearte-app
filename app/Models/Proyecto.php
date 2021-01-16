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
        'proyecto_cliente_id'
    ];

    //RELACIÓN DIRECTA HACIA CENTRO DE COSTOS
    public function centro_costo()
    {
        return $this->belongsTo('App\Models\CentroCosto', 'proyecto_centro_costo_id');
    }

    //RELACIÓN DIRECTA HACIA CLIENTE
    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'proyecto_cliente_id');
    }

    //RELACIÓN INVERSA HACIA SOLICITUD
    public function solicituds()
    {
        return $this->hasMany('App\Models\Solicitud');
    }
}
