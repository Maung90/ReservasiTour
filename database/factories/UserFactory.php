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
        static $roleIds = [1, 2, 3, 4, 5];
        static $index = 0;

        return [
            'nama' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'username' => fake()->unique()->username(),
            'password' => static::$password ??= Hash::make('password'),
            'notelp' => $this->faker->phoneNumber,
            'role_id' => $roleIds[$index++ % count($roleIds)], // Loop berulang ke awal jika lebih dari 5
            'email_verified_at' => now(),
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
}
