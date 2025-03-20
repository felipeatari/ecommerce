<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $name = ucwords(fake()->unique()->words(random_int(1, 3), true));

        return [
            'category_id' => Category::class,
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->text(),
            'active' => true,
        ];
    }
}
