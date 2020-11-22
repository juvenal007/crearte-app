<?php

namespace Database\Factories;

use App\Models\SolicitudCatalogo;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudCatalogoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SolicitudCatalogo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'solicitud_catalogo_cantidad' => $this->faker->numberBetween($min = 1, $max= 20),
            'solicituds_id' => $this->faker->numberBetween($min = 1, $max= 10),
            'catalogos_id' => $this->faker->numberBetween($min = 1, $max= 50)
        ];
    }
}
