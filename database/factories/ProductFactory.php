<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Subcategory;
use App\Models\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{

    protected $model = Product::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'sku'=> $this->faker->unique()->numberBetween(100000,999999),
            'name'=> $this->faker->sentence(),
            'descripcion'=> $this->faker->text(150),
            'image_path' => 'products/' . $this->faker->image('public/storage/products', 640,480,null,false), //products/1.jpg
            'price'=> $this->faker->randomFloat(2,1,1000),
            'subcategory_id' => Subcategory::factory(),
        ];
    }
}

