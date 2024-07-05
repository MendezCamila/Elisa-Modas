<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Family;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $families = [
            'Moda Hombre' => [
                'Tendencias y colecciones' => [
                    'Colección de verano',
                    'Lo mas nuevo',
                ],
                'Ropa de hombre por tipo' => [
                    'Abrigos',
                    'Camisas',
                    'Camisetas',
                    'Jeans',
                    'Pantalones',
                    'Polos',
                    'Ropa interior',
                    'Shorts',
                    'Trajes',
                    'Zapatos',
                ],
                'Accesorios' => [
                    'Billeteras',
                    'Cinturones',
                    'Corbatas',
                    'Gorros',
                    'Gafas',
                    'Guantes',
                    'Mochilas',
                    'Otros',
                    'Relojes',
                    'Sombreros',
                ],
                'Ropa interior y pijamas' => [
                    'Boxers',
                    'Pijamas',
                    'Ropa interior',
                ],
                'Calzado hombre' => [
                    'Botas',
                    'Casuales',
                    'Formales',
                    'Otros',
                    'Sandalias',
                    'Zapatillas',
                ],
            ],
            'Moda Mujer' => [
                'Tendencias y colecciones' => [
                    'Colección de verano',
                    'Lo mas nuevo',
                    'Comodidad',
                    'Colección otoño invierno',
                ],
                'Ropa de mujer por tipo' => [
                    'Abrigos',
                    'Blusas',
                    'Camisas',
                    'Camisetas',
                    'Jeans',
                    'Pantalones',
                    'Polos',
                    'Ropa interior',
                    'Shorts',
                    'Vestidos',
                    'Zapatos',
                ],
                'Accesorios' => [
                    'Billeteras',
                    'Cinturones',
                    'Gorros',
                    'Gafas',
                    'Guantes',
                    'Mochilas',
                    'Otros',
                    'Relojes',
                    'Sombreros',
                ],
                'Ropa interior y pijamas' => [
                    'Pijamas',
                    'Ropa interior',
                ],
                'Calzado mujer' => [
                    'Botas',
                    'Casuales',
                    'Formales',
                    'Otros',
                    'Sandalias',
                    'Zapatillas',
                ],
            ],
            'Moda Infantil' => [
                'Tendencias y colecciones' => [
                    'Colección de verano',
                    'Lo mas nuevo',
                    'Colección otoño invierno',
                ],
                'Ropa de niño por tipo' => [
                    'Abrigos',
                    'Camisas',
                    'Camisetas',
                    'Jeans',
                    'Pantalones',
                    'Polos',
                    'Ropa interior',
                    'Shorts',
                    'Zapatos',
                ],
                'Accesorios' => [
                    'Billeteras',
                    'Cinturones',
                    'Gorros',
                    'Gafas',
                    'Guantes',
                    'Mochilas',
                    'Otros',
                    'Relojes',
                    'Sombreros',
                ],
                'Ropa interior y pijamas' => [
                    'Boxers',
                    'Pijamas',
                    'Ropa interior',
                ],
                'Calzado niño' => [
                    'Botas',
                    'Casuales',
                    'Formales',
                    'Otros',
                    'Sandalias',
                    'Zapatillas',
                ],
                'Ropa de niña por tipo' => [
                    'Abrigos',
                    'Blusas',
                    'Camisas',
                    'Camisetas',
                    'Jeans',
                    'Pantalones',
                    'Polos',
                    'Ropa interior',
                    'Shorts',
                    'Vestidos',
                    'Zapatos',
                ],
                'Calzado niña' => [
                    'Botas',
                    'Casuales',
                    'Formales',
                    'Otros',
                    'Sandalias',
                    'Zapatillas',
                ],
            ],
        ];
        //Recorrer el array families
        //La primer llave representa a la (nombre familia) familia (llave)
        //y el otro representa las categorias (value)

        //Luego cada categoria tiene su subcategoria
        foreach ($families as $family => $categories) {

            $family= Family ::create([
                'name'=> $family,
            ]);

            //Bucle para recorrer las categorias
            foreach ($categories as $categoy => $subcategories) {
                $category= Category::create([
                    'name'=> $categoy,
                    'family_id'=> $family->id,
                ]);
                foreach ($subcategories as $subcategory) {
                    Subcategory::create([
                        'name'=> $subcategory,
                        'category_id'=> $category->id,
                    ]);
            }
        }
    } } }

