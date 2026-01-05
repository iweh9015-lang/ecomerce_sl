<?php

// database/factories/ProductFactory.php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->words(rand(2, 5), true);
        $price = fake()->numberBetween(50000, 10000000);

        return [
            'category_id' => Category::inRandomOrder()->first()?->id ?? Category::factory(),
            'name' => ucwords($name),
            'slug' => Str::slug($name).'-'.fake()->unique()->numberBetween(1000, 9999),
            'description' => fake()->paragraphs(rand(2, 5), true),
            'price' => $price,
            'discount_price' => fake()->optional(0.3)->numberBetween(
                (int) ($price * 0.5),
                (int) ($price * 0.9)
            ),
            'stock' => fake()->numberBetween(0, 100),
            'weight' => fake()->numberBetween(100, 5000),
            'is_active' => fake()->boolean(90),
            'is_featured' => fake()->boolean(10),
        ];
    }

    // State modifiers
    public function featured(): static
    {
        return $this->state(fn () => [
            'is_featured' => true,
            'is_active' => true,
        ]);
    }

    public function onSale(): static
    {
        return $this->state(function (array $attributes) {
            $price = $attributes['price'];

            return [
                'discount_price' => (int) ($price * fake()->randomFloat(2, 0.5, 0.8)),
            ];
        });
    }

    public function outOfStock(): static
    {
        return $this->state(fn () => ['stock' => 0]);
    }
}
