<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kendaraan>
 */
class KendaraanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Kendaraan::class;
    public function definition(): array
    {
        return [
        'nomor_kendaraan' => $this->faker->regexify('[A-Z]{4}') ,
        'jenis_kendaraan' => $this->faker->word,
        'kapasitas' => $this->faker->numberBetween(1, 5),
        'status' => 'available',
        ];
    }
}
