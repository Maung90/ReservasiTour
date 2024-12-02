<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Vendor;  
use App\Models\User; 

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produk>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = \App\Models\Produk::class;
    public function definition(): array
    {
        return [
            'nama_produk' => $this->faker->word(),
            'harga' => $this->faker->numberBetween(150000, 250000),
            'area' => $this->faker->word(),
            'deskripsi' => $this->faker->paragraph(),
            'tipe_produk' => 'etc',
            'vendor_id' => Vendor::inRandomOrder()->value('id'),
            'created_by' => User::inRandomOrder()->value('id'),
            'updated_by' => User::inRandomOrder()->value('id'),
     ];
 }
}
