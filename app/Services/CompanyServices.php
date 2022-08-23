<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyServices
{
    public function getCompanies()
    {
        $compamies = Company::select('id', 'name', 'status', 'max_user')
        ->paginate(10);

        foreach ($compamies as $company) {
            $company->companyAccount;
            $company->countUser = $company->users->count();
        }
        return $compamies;
    }

    public function storeCompany($data)
    {
        return Company::create($data);
    }

    public function updateCompany($data, $company)
    {
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