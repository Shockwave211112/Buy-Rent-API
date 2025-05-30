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
        return [
            'name' => fake()->companySuffix(),
            'price' => fake()->randomFloat(2, 1000, 40000),
            'count' => fake()->randomNumber(2),
            'rent_price_4h' => fake()->randomFloat(2, 50, 300),
            'rent_price_8h' => fake()->randomFloat(2, 300, 600),
            'rent_price_12h' => fake()->randomFloat(2, 600, 900),
            'rent_price_24h' => fake()->randomFloat(2, 900, 1200),
        ];
    }

    /**
     * Задать цену.
     *
     * @param string $price
     * @return $this
     */
    public function withPrice(string $price): static
    {
        return $this->state(fn () => ['price' => $price]);
    }

    /**
     * Задать аренду.
     *
     * @param string $price
     * @return $this
     */
    public function withRent(string $price): static
    {
        return $this->state(fn () => [
            'rent_price_4h' => $price,
            'rent_price_8h' => $price,
            'rent_price_12h' => $price,
            'rent_price_24h' => $price,
        ]);
    }

    /**
     * Задать количество.
     *
     * @param string $count
     * @return $this
     */
    public function withCount(string $count): static
    {
        return $this->state(fn () => ['count' => $count]);
    }

    /**
     * Создать удаленный товар
     *
     * @return $this
     */
    public function deleted(): static
    {
        return $this->state(fn () => ['deleted_at' => now()]);
    }
}
