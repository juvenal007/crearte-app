<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estados')->insert([
            [
                'estado' => 'SOLICITUD_ACTIVA',
                'estado_descripcion' => 'CREADA'
            ],
            [
                'estado' => 'SOLICITUD_TERMINADA',
                'estado_descripcion' => 'EN PROCESO'
            ],
            [
                'estado' => 'INICIADA',
                'estado_descripcion' => 'INICIADA'
            ],
            [
                'estado' => 'APROBADA',
                'estado_descripcion' => 'APROBADA'
            ],
            [
                'estado' => 'EN PROCESO DE COMPRA',
                'estado_descripcion' => 'EN PROCESO DE COMPRA'
            ],
            [
                'estado' => 'COMPRA TERMINADA',
                'estado_descripcion' => 'COMPRA TERMINADA'
            ],
            [
                'estado' => 'TERMINADA',
                'estado_descripcion' => 'TERMINADA'
            ],
            [
                'estado' => 'PROYECTO_ACTIVO',
                'estado_descripcion' => 'TERMINADA'
            ],
            [
                'estado' => 'PROYECTO_TERMINADO',
                'estado_descripcion' => 'TERMINADA'
            ],
            [
                'estado' => 'CLIENTE_ACTIVO',
                'estado_descripcion' => 'TERMINADA'
            ],
            [
                'estado' => 'CLIENTE_TERMINADO',
                'estado_descripcion' => 'TERMINADA'
            ],
            [
                'estado' => 'CENTRO_COSTO_ACTIVO',
                'estado_descripcion' => 'TERMINADA'
            ],
            [
                'estado' => 'CENTRO_COSTO_TERMINADO',
                'estado_descripcion' => 'TERMINADA'
            ],
            [
                'estado' => 'COTIZACION_ACTIVA',
                'estado_descripcion' => 'TERMINADA'
            ],
            [
                'estado' => 'COTIZACION_TERMINADA',
                'estado_descripcion' => 'TERMINADA'
            ],
        ]
        );
    }
}
