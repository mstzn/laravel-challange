<?php

namespace Database\Factories;

use App\Models\CompanyPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyPackageFactory extends Factory
{
    protected $model = CompanyPackage::class;

    public function definition(): array
    {
        return [
            'start_date' => $this->faker->dateTimeBetween('-1 year'),
            'end_date' => $this->faker->dateTimeBetween('-1 year', '2 years'),
            'is_active' => 1,
        ];
    }
}
