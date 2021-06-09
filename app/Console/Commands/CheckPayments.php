<?php

namespace App\Console\Commands;

use App\Jobs\ProcessCompanyPayment;
use App\Models\CompanyPackage;
use DateTime;
use Illuminate\Console\Command;

class CheckPayments extends Command
{
    protected $signature = 'check_payments';

    protected $description = 'Check company payments';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle(): int
    {
        $currentDate = new DateTime('now');

        $expiredSubscriptions = CompanyPackage::where('end_date', '<', $currentDate)->where('is_active', 1)->get()->all();

        if (!empty($expiredSubscriptions)) {
            foreach ($expiredSubscriptions as $expiredSubscription) {
                ProcessCompanyPayment::dispatch($expiredSubscription)->onQueue('default');
            }
        }

        return 1;
    }
}
