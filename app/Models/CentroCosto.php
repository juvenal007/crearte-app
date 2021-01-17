<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CentroCosto extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'centro_costos';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at','updated_at','deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'cc_nombre',
        'cc_direccion',
        'cc_estado_id'
    ];

    //RELACIÓN INVERSA HACIA CENTRO DE COSTOS
    public function proyectos()
    {
        return $this->hasMany('App\Models\Proyecto');
    }
    public function detalle_solicituds()
    {
        return $this->hasMany('App\Models\DetalleSolicitud');
    }
    public function estado()
    {
        return $this->belongsTo('App\Models\DetalleSolicitud', 'cc_estado_id');
    }


}
