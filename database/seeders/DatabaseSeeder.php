<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyPackage;
use App\Models\Package;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Package::factory(5)->create();
        Company::factory()->count(10)->create()->each(function ($company) {
            CompanyPackage::factory()->for($company)->for(Package::inRandomOrder()->first())->createOne();
        });

    }
}
