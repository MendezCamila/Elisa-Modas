<?php

namespace Database\Factories;
use App\Models\Variant;
use App\Models\PreVenta;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PreVenta>
 */
class PreVentaFactory extends Factory
{
    protected $model = PreVenta::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            /* mi tabla preventas tiene las siguientes columnas:
            	id	variant_id	cantidad	descuento	fecha_inicio	fecha_fin	estado	created_at	updated_at*/
            'variant_id' => Variant::factory(),
            'cantidad' => $this->faker->numberBetween(1, 100),
            'descuento' => $this->faker->numberBetween(1, 10),
            'fecha_inicio' => $this->faker->dateTimeBetween('-1 month', 'now'),

            'fecha_fin' => $this->faker->dateTimeBetween('now', '+1 month'),
            'estado' => 'activo',


        ];
    }
}
