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
        ->withCount('users')
        ->with('companyAccount')
        ->orderBy('id', 'desc')
        ->paginate(10);

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

        if (Auth::user()->role_id == User::ROLE_ADMIN){
            return true;
        }
        return $company->status == Company::STATUS_ACTIVATE;
    }

    public function deleteCompany($company)
    {
        $company->delete();
        return $company->trashed();
    }
}