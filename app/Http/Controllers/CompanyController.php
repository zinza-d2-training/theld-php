<?php

namespace App\Http\Controllers;

use App\Http\Requests\Company\StoreCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Models\Company;
use App\Models\User;
use App\Services\CompanyServices;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(CompanyServices $companyServices)
    {
        $this->companyServices = $companyServices;
    }

    public function index()
    {
        $companies = $this->companyServices->getCompanies();

        return view('company.list',[
            'companies' => $companies
        ]);
    }

    public function create()
    {
        return view('company.form', [
            'isEditing' => false
        ]);
    }

    public function store(StoreCompanyRequest $request)
    {
        $this->companyServices->storeCompany($request);

        return redirect()->route('company.index')->withSuccess('Create Company Successfully');
    }

    public function edit(Company $company)
    {
        return view('company.form', [
            'isEditing' => true,
            'company' => $company,
        ]);
    }

    public function update(UpdateCompanyRequest $request, Company $company)
    {
        $updated = $this->companyServices->updateCompany($request, $company);

        if (!$updated) {
            return back()->withErrors('Failed to change Max User');
        }

        return back()->withSuccess('Update Company Successfully');
    }

    public function destroy(Company $company)
    {
        $deleted = $this->companyServices->deleteCompany($company);

        if (!$deleted) {
            return back()->withErrors('Delete Company Failed');
        }
        return redirect()->route('company.index')->withSuccess('Delete Company Successfully');
    }
}
