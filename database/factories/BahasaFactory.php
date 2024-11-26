<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\bahasa>
 */
class BahasaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Bahasa::class;
    public function definition(): array
    {
        return [
            'nama_bahasa' => $this->faker->country,
            'harga_bahasa' => $this->faker->numberBetween(50000, 100000), 
        ];
    }
}
