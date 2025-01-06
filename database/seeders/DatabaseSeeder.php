<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // RoleSeeder::class,
            // BahasaSeeder::class,
            // VendorSeeder::class,
            // SopirSeeder::class,
            // UserSeeder::class,
            // ProdukSeeder::class,
            // ProgramSeeder::class,
            // GuideSeeder::class,
            // KendaraanSeeder::class,
            // ReservasiSeeder::class,
            TagihanSeeder::class,
            GuideHasBahasaSeeder::class,
            DetailProgramSeeder::class,
            CustomReservasiSeeder::class,
            FlightSeeder::class,
            ReservasiActivitiesSeeder::class,
        ]);
    }
}
