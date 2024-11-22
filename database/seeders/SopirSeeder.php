<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sopir;

class SopirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sopir::factory()->count(10)->create();
    }
}
