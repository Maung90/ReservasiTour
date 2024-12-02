<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Program;  
use App\Models\Produk; 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailProgram>
 */
class DetailProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\DetailProgram::class;
    public function definition(): array
    {
        return [
            'program_id' =>Program::inRandomOrder()->value('id'),
            'produk_id' => Produk::inRandomOrder()->value('id'),
        ];
    }
}
