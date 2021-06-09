<?php

namespace App\Jobs;

use App\Models\Company;
use App\Models\CompanyPackage;
use App\Models\CompanyPayment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCompanyPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private CompanyPackage $companyPackage;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CompanyPackage $companyPackage)
    {
        //
        $this->companyPackage = $companyPackage;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $company = Company::where('id', $this->companyPackage->company_id)->get()->first();

        $companyPayment = new CompanyPayment();
        $companyPayment->company_id = $this->companyPackage->company_id;
        $companyPayment->package_id = $this->companyPackage->package_id;
        $companyPayment->paid = rand(0, 10000) % 2 == 0 ? 0 : 1;
        $companyPayment->save();

        if ($companyPayment->paid) {
            $company->subscribe($this->companyPackage->package_id);
        } else {

            if ($this->attempts() >= 3) {
                $this->companyPackage->is_active = 0;
                $this->companyPackage->save();

                $company->suspend();
            } else {
                $this->fail(new \Exception('Payment Failed!'));
            }
        }
    }
}
