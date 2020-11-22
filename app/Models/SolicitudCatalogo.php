<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SolicitudCatalogo extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'solicitud_catalogos';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'solicitud_catalogo_cantidad',
        'catalogos_id',
        'solicituds_id'
    ];

    //RELACIÓN DIRECTA HACIA CATALOGO
    public function catalogos()
    {
        return $this->belongsTo('App\Models\Catalogo', 'catalogos_id');
    }

    //RELACIÓN DIRECTA HACIA SOLICITUD
    public function solicituds()
    {
        return $this->belongsTo('App\Models\Solicitud', 'solicituds_id');
    }

    //RELACIÓN INVERSA HACIA SOLICITUD
    public function solicitud()
    {
        return $this->hasMany('App\Models\Solicitud', 'solicituds_id');
    }
     //RELACIÓN INVERSA HACIA CATALOGO
     public function catalogo()
     {
         return $this->hasMany('App\Models\Catalogo', 'catalogos_id');
     }
}
