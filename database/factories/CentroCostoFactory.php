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
            'nombre' => $this->faker->name,
            'direccion' => $this->faker->text(50)
        ];
    }
}
