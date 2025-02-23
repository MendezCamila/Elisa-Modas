<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\Subcategory;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subcategory>
 */
class SubcategoryFactory extends Factory
{
    protected $model = Subcategory::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           // Nombre de la subcategoría
           'name' => $this->faker->word,
           // Se asocia una categoría automáticamente mediante la factory de Category
           'category_id' => Category::factory(),
        ];
    }
}
