<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Reservasi;  
use App\Models\Produk; 
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CustomReservasi>
 */
class CustomReservasiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\CustomReservasi::class;
    public function definition(): array
    {
        return [
            'reservasi_id' => Reservasi::inRandomOrder()->value('id'),
            'produk_id' => Produk::inRandomOrder()->value('id'),
        ];
    }
}
