<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guide>
 */
class GuideFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Guide::class;
    public function definition(): array
    {
        return [
            'nama_guide' => $this->faker->name(),
            'no_telp'=> $this->faker->phoneNumber(),
            'status'=> 'available',
        ];
    }
}
