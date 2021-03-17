<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BodegaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bodegas')->insert([
            [
                'bodega_nombre' => 'BODEGA_GENERAL',
                'bodega_descripcion' => 'BODEGA_GENERAL'
            ],           
        ]
        );
    }
}
