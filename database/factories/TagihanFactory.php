<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reservasi;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tagihan>
 */
class TagihanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Tagihan::class;
    public function definition(): array
    {
        return [ 
            'total'  => $this->faker->numberBetween(50000, 100000),
            'status' => 'paid',
            'reservasi_id' => Reservasi::inRandomOrder()->value('id'),
            'created_by' => User::inRandomOrder()->value('id'),
            'updated_by' => User::inRandomOrder()->value('id'),
        ];
    }
}
