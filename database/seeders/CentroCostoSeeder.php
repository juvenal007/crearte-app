<?php

namespace Database\Seeders;

use App\Models\CentroCosto;
use Illuminate\Database\Seeder;


class CentroCostoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CentroCosto::factory()
            ->times(50)            
            ->create();
    }
}
