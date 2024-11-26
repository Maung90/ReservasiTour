<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['role' => 'admin'],
            ['role' => 'production'],
            ['role' => 'operation'],
            ['role' => 'accounting'],
            ['role' => 'agent'],
        ];
        Role::insert($data);
    }
}
