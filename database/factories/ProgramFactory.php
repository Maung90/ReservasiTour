<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Program>
 */
class ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Program::class;
    public function definition(): array
    {
        return [
            'nama_program' => $this->faker->word(),
            'deskripsi' => $this->faker->sentence(),
            'durasi' => $this->faker->numberBetween(1, 7),
            'created_by' => User::inRandomOrder()->value('id'),
            'updated_by' => User::inRandomOrder()->value('id'),
        ];
    }
}
