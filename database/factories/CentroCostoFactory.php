<?php

namespace Database\Factories;

use App\Models\CentroCosto;
use App\Models\Estado;
use Illuminate\Database\Eloquent\Factories\Factory;

class CentroCostoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CentroCosto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $estado = Estado::where('estado', 'CENTRO_COSTO_ACTIVO')->first();
        return [
            'cc_nombre' => 'CENTRO COSTO-'.rand(1000, 4000),
            'cc_direccion' => 'DIRECCIÓN-'.rand(1000, 4000),
            'cc_estado_id' => $estado->id
        ];
    }
}
