<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Program;
use App\Models\Guide;  
use App\Models\Kendaraan;
use App\Models\Sopir; 
use App\Models\Bahasa;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reservasi>
 */
class ReservasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Reservasi::class;
    public function definition(): array
    {
         return [
            'dob' => $this->faker->date(),
            'tour_date' => $this->faker->date(),
            'program_id' => Program::inRandomOrder()->value('id'), 
            'pax' => $this->faker->numberBetween(1, 50),
            // 'agent' => $this->faker->company(),
            'guest_name' => $this->faker->name(),
            'tour_code' => $this->faker->lexify('TOUR-????'),
            'contact' => $this->faker->phoneNumber(),
            'hotel' => $this->faker->company(),
            'pickup' => $this->faker->datetime(),
            'guide_id' => Guide::inRandomOrder()->value('id'), 
            'transport_id' => Kendaraan::inRandomOrder()->value('id'),
            'sopir_id' => Sopir::inRandomOrder()->value('id'),
            'remarks' => $this->faker->paragraph(),
            'bahasa_id' => Bahasa::inRandomOrder()->value('id'),
            'created_by' => User::inRandomOrder()->value('id'),
            'updated_by' => User::inRandomOrder()->value('id'),
        ];
    }
}
