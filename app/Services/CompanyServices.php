<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyServices
{
    public function getCompanies()
    {
        $companies = Company::select('id', 'name', 'status', 'max_user')
        ->orderBy('id', 'desc')
        ->paginate(10);

        foreach ($companies as $company) {
            $company->companyAccount;
            $company->countUser = $company->users->count();
        }
        return $companies;
    }

    public function storeCompany($request)
    {
        $data = $request->input();

        if ($request->hasFile('logo')) {
            $fileName = $request->logo->hashName();
            $data['logo'] = $request->logo->storeAs('images/company', $fileName);
        }

        return Company::create($data);
    }

    public function updateCompany($request, $company)
    {
        $data = $request->input();

        if ($request->hasFile('logo')) {
            $fileName = $request->logo->hashName();
            $data['logo'] = $request->logo->storeAs('images/company', $fileName);
        }

        $count = $company->users->count();
        if ($data['max_user'] < $count) {
            return false;
        }
        return $company->update($data);
    }

    public function isActivate($id)
    {
        $company = Company::find($id);

        if (Auth::user()->role_id == User::role_admin){
            return true;
        }
        return $company->status == Company::status_activate;
    }

    public function deleteCompany($company)
    {
        $company->delete();
        return $company->trashed();
    }
}