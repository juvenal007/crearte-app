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
        'nombre',
        'direccion',
        'descripcion',
        'telefono_ad',       
        'centro_costos_id',
        'clientes_id'
    ];

    //RELACIÓN DIRECTA HACIA CENTRO DE COSTOS
    public function centro_costos()
    {
        return $this->belongsTo('App\Models\CentroCosto');
    }

    //RELACIÓN DIRECTA HACIA CLIENTE
    public function clientes()
    {
        return $this->belongsTo('App\Models\Cliente');
    }

    //RELACIÓN INVERSA HACIA SOLICITUD
    public function solicituds()
    {
        return $this->hasMany('App\Models\Solicitud');
    }
}
