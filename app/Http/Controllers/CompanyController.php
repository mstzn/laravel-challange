<?php

namespace App\Http\Controllers;

use App\Http\Traits\ApiResponseTrait;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CompanyController extends Controller
{
    use ApiResponseTrait;

    public function create()
    {
        //
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): array
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'lastname' => 'required|string',
            'company_name' => 'required|string',
            'site_url' => 'url',
            'email' => 'required|email|unique:companies',
            'password' => 'required|confirmed'
        ]);

        if ($validation->fails()) {
            return $this->createResponse(false, [], $validation->errors()->first());
        }

        $validatedData = $validation->validated();
        
        $company = new Company();
        $company->name = $validatedData['name'];
        $company->lastname = $validatedData['lastname'];
        $company->company_name = $validatedData['company_name'];
        $company->site_url = $validatedData['site_url'];
        $company->email = $validatedData['email'];
        $company->password = Hash::make($validatedData['password']);

        $company->save();

        $token = $company->createToken('api-token')->plainTextToken;

        return $this->createResponse(true, [
            'id' => $company->id,
            'token' => $token
        ]);
    }

    public function show($id)
    {
        //
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
