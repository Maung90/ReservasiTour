<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Guide;
use App\Models\Bahasa;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GuideHasBahasa>
 */
class GuideHasBahasaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = \App\Models\GuideHasBahasa::class;
    public function definition(): array
    {
        return [
            'guide_id' => Guide::inRandomOrder()->value('id'),
            'bahasa_id' => Bahasa::inRandomOrder()->value('id'),
        ];
    }
}
