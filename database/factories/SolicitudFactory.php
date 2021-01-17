<?php

namespace Database\Factories;

use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Factories\Factory;

class SolicitudFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Solicitud::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       /*  return [
            'solicitud_codigo' => 'CODIGO-'.rand(1000, 4000),
            'solicitud_nombre' => 'NOMBRE-'.rand(1000, 4000),
            'solicitud_descripcion' => 'DESCRIPCIÓN-'.rand(1000, 4000),
            'solicitud_nombre_solicitante' => 'SOLICITANTE-'.rand(1000, 4000),
            'solicitud_estado_id' => 1,
            'solicitud_proyecto_id' => $this->faker->numberBetween($min = 1, $max= 50)
        ]; */
    }
}

