<?php

namespace App\Http\Traits;

use App\Models\CompanyPackage;
use App\Models\Package;
use DateInterval;
use DateTime;
use Illuminate\Database\Eloquent\Model;

trait SubscriptionTrait {

    public function subscribe($packageID = 0): CompanyPackage
    {
        $package = Package::where('id', $packageID)->first();

        $currentDate = new DateTime('now');

        $companyPackage = new CompanyPackage();
        $companyPackage->company_id = $this->id;
        $companyPackage->package_id = $packageID;
        $companyPackage->start_date = $currentDate->format('Y-m-d');
        $companyPackage->end_date = $currentDate->add(DateInterval::createFromDateString('1 ' . ($package->period == 'yearly' ? 'year' : 'month')))->format('Y-m-d');
        $companyPackage->save();

        return $companyPackage;
    }

}
