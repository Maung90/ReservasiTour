<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorSeeder extends Seeder
{
    public function run()
    {
        // Membuat 50 data vendor menggunakan factory
        Vendor::factory()->count(10)->create();
    }
}
