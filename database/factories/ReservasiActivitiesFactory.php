<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservasi;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReservasiActivities>
 */
class ReservasiActivitiesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\ReservasiActivities::class;
    public function definition(): array
    {
        return [
            'aktivitas' => $this->faker->sentence(),
            'reservasi_id' => Reservasi::inRandomOrder()->value('id'),
        ];
    }
}
