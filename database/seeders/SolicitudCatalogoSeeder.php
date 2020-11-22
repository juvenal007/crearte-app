<?php

namespace Database\Seeders;

use App\Models\SolicitudCatalogo;
use Illuminate\Database\Seeder;

class SolicitudCatalogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SolicitudCatalogo::factory()
        ->times(500)            
        ->create();
    }
}
