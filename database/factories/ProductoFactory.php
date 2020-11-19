<?php

namespace Database\Factories;

use App\Models\Producto;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Producto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'producto_material' => $this->faker->text(10),
            'producto_descripcion' => $this->faker->text(20),
            'producto_unidad' => $this->faker->text(5),
            'proveedors_id' => $this->faker->numberBetween($min = 1, $max = 30)
        ];
    }
}
