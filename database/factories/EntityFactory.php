<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity>
 */
class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(20),
    	    'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec sit amet sapien at augue cursus molestie a et nibh. Vivamus hendrerit sem id mauris laoreet mattis. Donec quis augue sit amet el",
    	    'urlweb' => fake()->url(),
    	    'image' => fake()->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'latitud' => fake()->latitude(), 
            'longitud' => fake()->longitude(), 
            'direccion' => fake()->address(20), 
            'destacado' => fake()->boolean(),
            'sectores_id' => fake()->numberBetween(1, 3),
            'categories_id' => fake()->numberBetween(1, 3),

        ];
    }



}
