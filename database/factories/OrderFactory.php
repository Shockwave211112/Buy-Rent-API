<?php

namespace Database\Factories;

use App\Enums\OrderTypeEnum;
use App\Models\Product;
use App\Models\User;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startAt = $this->faker->dateTimeBetween('-30 days', 'now');
        $endAt = (clone $startAt)->modify('+' . rand(1, 24) . ' hours');

        return [
            'product_id' => Product::inRandomOrder()->value('id') ?? Product::factory(),
            'type' => $this->faker->randomElement(['rent', 'purchase']),
            'start_at' => $startAt,
            'end_at' => $endAt,
            'user_id' => User::inRandomOrder()->value('id') ?? User::factory(),
        ];
    }

    /**
     * Задать владельца
     *
     * @param User $user
     * @return $this
     */
    public function withUser(User $user): static
    {
        return $this->state(fn () => ['user_id' => $user->id]);
    }

    /**
     * Задать тип заказа
     *
     * @param OrderTypeEnum $type
     * @return $this
     */
    public function withType(OrderTypeEnum $type): static
    {
        return $this->state(fn () => ['type' => $type]);
    }

    /**
     * Задать купленный товар
     *
     * @param Product $product
     * @return $this
     */
    public function withProduct(Product $product): static
    {
        return $this->state(fn () => ['product_id' => $product]);
    }

    /**
     * Задать статус заказа
     *
     * @param bool $status
     * @return $this
     */
    public function withStatus(bool $status): static
    {
        return $this->state(fn () => ['is_active' => $status]);
    }

    /**
     * Задать дату начала
     *
     * @return $this
     */
    public function withStart(DateTime $date): static
    {
        return $this->state(fn () => ['start_at' => $date]);
    }

    /**
     * Задать дату конца
     *
     * @return $this
     */
    public function withEnd(DateTime $date): static
    {
        return $this->state(fn () => ['end_at' => $date]);
    }
}
