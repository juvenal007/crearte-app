<?php

namespace Database\Factories;

use App\Models\Proyecto;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProyectoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Proyecto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {       
        return [
            'nombre' => $this->faker->name,
            'direccion' => $this->faker->address,
            'descripcion' => $this->faker->text(50),
            'telefono_ad' => $this->faker->e164PhoneNumber,
            'centro_costos_id' => $this->faker->numberBetween($min = 1, $max= 50)
        ];
    }
}
