<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $options = [
            [
                'name' => 'Talla',
                'type' => '1',
                'features' => [
                    [
                        'value' => 'S',
                        'description' => 'Pequeño'
                    ],
                    [
                        'value' => 'M',
                        'description' => 'Mediano'
                    ],
                    [
                        'value' => 'L',
                        'description' => 'Grande'
                    ],
                    [
                        'value' => 'XL',
                        'description' => 'Extra grande'
                    ],
                ],
            ],
            [
                'name' => 'Color',
                'type' => '2',
                'features' => [
                    [
                        'value' => '#000000',
                        'description' => 'negro'
                    ],
                    [
                        'value' => '#ffffff',
                        'description' => 'blanco'
                    ],
                    [
                        'value' => '#ff0000',
                        'description' => 'rojo'
                    ],
                    [
                        'value' => '#00ff00',
                        'description' => 'verde'
                    ],
                    [
                        'value' => '#0000ff',
                        'description' => 'azul'
                    ],
                    [
                        'value' => '#ffff00',
                        'description' => 'amarillo'
                    ],
                    [
                        'value' => '#00ffff',
                        'description' => 'cian'
                    ],
                ],
            ],
            [
                'name' => 'Sexo',
                'type' => '1',
                'features' => [
                    [
                        'value' => 'm',
                        'description' => 'masculino'
                    ],
                    [
                        'value' => 'f',
                        'description' => 'femenino'
                    ],
                ],
            ],
        ];

        foreach ($options as $option) {
            $optionModel = Option::create([
                'name' => $option['name'],
                'type' => $option['type'],
            ]);

            foreach ($option['features'] as $feature) {
                $optionModel->features()->create([
                    'value' => $feature['value'],
                    'description' => $feature['description'],
                ]);
            }
        }
    }
}
