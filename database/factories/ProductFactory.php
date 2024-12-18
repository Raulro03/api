<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
             // inRandomOrder() esta creado en Builder.php
            'description' => fake()->paragraph,
            'price' => rand(1000, 99999),
            'photo' => fake()->words(asText: true),
        ];
    }
}
