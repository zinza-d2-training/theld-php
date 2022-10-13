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
        ->paginate(config('constant.paginate.maxRecord'));

        return $companies;
    }

    public function getForCreateUser()
    {
        if (Auth::user()->role_id == User::ROLE_COMPANY_ACCOUNT) {
            return [Auth::user()->company];
        }
        else {
            return Company::select('id', 'name', 'max_user', 'expired_at', 'status')
            ->where('expired_at', '>', now())
            ->where('status', Company::STATUS_ACTIVATE)
            ->get();
        }
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
        if (data_get($data, 'max_user') < $count) {
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