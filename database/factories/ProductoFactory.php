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
            'producto_material' => 'MATERIAL-'.rand(1000, 4000),
            'producto_descripcion' => 'DESCRIPCIÓN-'.rand(1000, 4000),
            'producto_unidad' => 'UNIDAD-'.rand(1000, 4000),
            'producto_proveedor_id' => $this->faker->numberBetween($min = 1, $max = 30)
        ];
    }
}
