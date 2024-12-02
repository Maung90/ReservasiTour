<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Reservasi;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Flight>
 */
class FlightFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Flight::class;

    public function definition(): array
    {
        return [
            'flight_code' => $this->faker->lexify('FC-????'),
            'type' => 'arrival',
            'time' => $this->faker->datetime(),
            'reservasi_id' => Reservasi::inRandomOrder()->value('id'),
        ];
    }
}
