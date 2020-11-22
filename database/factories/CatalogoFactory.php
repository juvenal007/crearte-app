<?php

namespace Database\Factories;

use App\Models\Catalogo;
use Illuminate\Database\Eloquent\Factories\Factory;

class CatalogoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Catalogo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'catalogo_material' => $this->faker->text(10),
            'catalogo_descripcion' => $this->faker->text(20),
            'catalogo_unidad' => $this->faker->text(5),           
        ];
    }
}
