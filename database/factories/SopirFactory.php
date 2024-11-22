<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sopir>
 */
class SopirFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\Sopir::class;

    public function definition(): array
    {
        return [
            'nama_sopir' => $this->faker->name,
            'no_telp' => $this->faker->phoneNumber,
        ];
    }
}
