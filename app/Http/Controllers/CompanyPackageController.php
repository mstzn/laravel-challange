<?php

namespace App\Http\Controllers;

use App\Exceptions\AlreadySubscribedException;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\PackageResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\CompanyPackage;
use App\Models\Package;
use DateInterval;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CompanyPackageController extends Controller
{
    use ApiResponseTrait;

    public function create()
    {
        //
    }

    /**
     * @throws ValidationException
     * @throws AlreadySubscribedException
     */
    public function store(Request $request): array
    {
        $validation = Validator::make($request->all(), [
            'company_id' => 'required|exists:companies,id',
            'package_id' => 'required|exists:packages,id',
        ]);

        if ($validation->fails()) {
            throw new ValidationException($validation);
        }

        $validatedData = $validation->validated();

        $company = Auth('sanctum')->user();

        $currentDate = new DateTime('now');

        // Check company for active packages
        $companyPackageExists = CompanyPackage::where('company_id', $company->id)->where('end_date', '>', $currentDate->format('Y-m-d'))->first();

        if (!empty($companyPackageExists)) {
            throw new AlreadySubscribedException($company->name. " already has an active subscription.");
        }

        $package = Package::where('id', $validatedData['package_id'])->first();

        $companyPackage = $company->subscribe($validatedData['package_id']);

        return $this->createResponse(true, [
            'start_date' => $companyPackage->start_date,
            'end_date' => $companyPackage->end_date,
            'package' => PackageResource::make($package)
        ]);

    }

    public function show(): array
    {
        $company = Auth('sanctum')->user();
        $package = $company->packages()->latest()->first();

        return $this->createResponse(true, [
            'company' => CompanyResource::make($company),
            'package' => PackageResource::make($package->package)
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
