<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AppModelsProduct>
 */
class ProductFactory extends Factory
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
    	    'precio' => fake()->numberBetween(1, 3),
    	    'image' => fake()->randomElement(['1.jpg', '2.jpg', '3.jpg']),
            'entidades_id' => fake()->numberBetween(1, 3)
        ];
    }
}
