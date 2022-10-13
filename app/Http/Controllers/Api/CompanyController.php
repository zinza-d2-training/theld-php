<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Services\CompanyServices;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    private $companyServices;
    
    public function __construct(CompanyServices $companyServices)
    {
        $this->companyServices = $companyServices;
    }

    public function getAll()
    {
        $companies = $this->companyServices->getForCreateUser();

        return response([
            'data' => $companies
        ], 200);
    }
    
    public function getList()
    {
        $companies = $this->companyServices->getCompanies();

        return response([
            'data' => $companies
        ], 200);
    }

    public function getOne(Company $company)
    {
        return response([
            'data' => $company,
        ], 200);
    }

    public function store(StoreCompanyRequest $request)
    {
        $company = $this->companyServices->storeCompany($request);

        return response([
            'message' => 'Create Company Successfully',
            'data' => $company
        ], 201);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $updated = $this->companyServices->updateCompany($request, $company);

        if (!$updated) {
            return response([
                'message' => 'Failed to change Max User'
            ], 400);
        }

        return response([
            'message' => 'Update Company Successfully'
        ], 200);
    }

    public function destroy(Company $company)
    {
        $deleted = $this->companyServices->deleteCompany($company);

        if (!$deleted) {
            return response([
                'message' => 'Delete Company Failed'
            ], 400);
        }
        return response([
            'message' => 'Delete Company Successfully'
        ], 200);
    }
}
