<?php

namespace Database\Factories;

use App\Models\CentroCosto;
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
        return [
            'nombre' => 'CENTRO COSTO-'.rand(1000, 4000),
            'direccion' => 'DIRECCIÓN-'.rand(1000, 4000),
        ];
    }
}
