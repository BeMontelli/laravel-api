<?php

namespace Database\Factories;

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
        $images = [
            'images/placeholders/type-1.png',
            'images/placeholders/type-2.png',
            'images/placeholders/type-3.png',
            'images/placeholders/type-4.png',
        ];

        return [
            'name' => fake()->sentence(rand(2,3)),
            'description' => fake()->sentence(4),
            'stock' => rand(0,100),
            'price' => mt_rand (0*10, 10*10) / 10,
            'image' => $images[rand(0,3)],
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s")
        ];
    }
}
