<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->toUpper($this->faker->word),
            'period' => $this->faker->boolean ? 'monthly' : 'yearly',
        ];
    }
}
