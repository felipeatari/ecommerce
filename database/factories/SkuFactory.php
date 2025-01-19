<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Variation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sku>
 */
class SkuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'product_id' => Product::class,
            'variation_id_1' => Variation::class,
            'variation_id_2' => Variation::class,
            'stock' => random_int(0, 10),
            'price' => (fake()->randomFloat(2, 50, 110) * 100),
            'weight' => fake()->randomFloat(3, 0.050, 0.200),
            'width' => fake()->randomFloat(2, 10, 15),
            'height' => fake()->randomFloat(2, 2, 3),
            'length' => fake()->randomFloat(2, 15, 25),
            'cover' => fake()->imageUrl(),
        ];
    }
}
