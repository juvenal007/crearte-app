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
        return [
            'solicitud_codigo' => $this->faker->text(5)."-".$this->faker->numerify($string = '###'),
            'solicitud_nombre' => $this->faker->name,
            'solicitud_descripcion' => $this->faker->text(50),
            'solicitud_nombre_solicitante' => $this->faker->name,
            'estados_id' => 1,
            'proyectos_id' => $this->faker->numberBetween($min = 1, $max= 50)
        ];
    }
}
