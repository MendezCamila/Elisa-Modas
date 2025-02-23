<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;
use App\Models\Variant;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Variant>
 */
class VariantFactory extends Factory
{
    protected $model = Variant::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            /*mi tabla variants tiene las siguientes columnas
            : id	sku	stock	estado	stock_min	product_id	created_at	updated_at	image_path */
            'sku' => $this->faker->unique()->word,
            'stock' => $this->faker->numberBetween(1, 100),
            'estado' => 'activo',
            'stock_min' => $this->faker->numberBetween(1, 10),
           'product_id' => Product::factory(),
            'image_path' => 'images/remera.jpg',
        ];
    }
}
