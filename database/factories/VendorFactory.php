<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class VendorFactory extends Factory
{
    protected $model = \App\Models\Vendor::class;

    public function definition()
    {
        return [
            'nama_vendor' => $this->faker->company,
            'contact' => $this->faker->phoneNumber,
            'bank' => $this->faker->company,
            'no_rekening' => $this->faker->bankAccountNumber,
            'account_name' => $this->faker->name,
            'validity_period' => $this->faker->date,
        ];
    }
}
