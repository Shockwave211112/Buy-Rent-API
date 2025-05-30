<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Задать email
     *
     * @param string $email
     * @return $this
     */
    public function withEmail(string $email): static
    {
        return $this->state(fn () => ['email' => $email]);
    }

    /**
     * Задать пароль
     *
     * @param string $password
     * @return $this
     */
    public function withPassword(string $password): static
    {
        return $this->state(fn () => ['password' => Hash::make($password)]);
    }

    /**
     * Задать баланс на счету
     *
     * @param string $amount
     * @return $this
     */
    public function withBalance(string $amount): static
    {
        return $this->afterCreating(function ($user) use ($amount) {
           $user->wallet->balance = $amount;
           $user->wallet->save();
        });
    }
}
