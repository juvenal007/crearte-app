<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoSolicitudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipo_solicituds')->insert([
            [
                'ts_nombre' => 'CLIENTE',
                'ts_descripcion' => 'Los materiales solicitados solo se asignarán para el cliente seleccionado.'
            ],
            [
                'ts_nombre' => 'PROYECTO',
                'ts_descripcion' => 'Los materiales solicitados se podrán compartir entre los clientes de un solo proyecto'
            ],
            [
                'ts_nombre' => 'CENTRO DE COSTO',
                'ts_descripcion' => 'Los materiales solicitados se podrán compartir entre los distintos proyectos dentro de un centro de costo'
            ],
            [
                'ts_nombre' => 'STOCK GENERAL',
                'ts_descripcion' => 'Los materiales solicitados se podrán compartir en todos los centros de costos, proyectos y clientes.'
            ]
        ]
        );
    }
}
