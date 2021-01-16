<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetalleSolicitud extends Model
{
    use HasFactory, SoftDeletes;

    //DEFINIMOS EL NOMBRE DE LA TABLA
    protected $table = 'detalle_solicituds';
    //DEFINIMOS LA CLAVE PRIMARIA DE LA TABLA, AUTOMATICAMENTE SE LE ASIGNA AUTO INCREMENT
    protected $primaryKey = 'id';

    //CAMPOS QUE NO QUEREMOS QUE SE DEVUELVAN EN LAS CONSULTAS
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    //ATRIBUTOS DE LA TABLE
    protected $fillable = [
        'ds_proyecto_id',
        'dc_cliente_id'
    ];

    //RELACIÓN DIRECTA HACIA PROYECTO
    public function proyecto()
    {
        return $this->belongsTo('App\Models\Proyecto', 'ds_proyecto_id');
    }

    //RELACIÓN DIRECTA HACIA CLIENTE
    public function cliente()
    {
        return $this->belongsTo('App\Models\Cliente', 'dc_cliente_id');
    }

}
