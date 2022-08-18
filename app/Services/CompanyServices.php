<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CompanyServices
{
    public function isActivate($id)
    {
        $company = Company::find($id);

        if (Auth::user()->role_id == User::role_admin){
            return true;
        }
        return $company->status == Company::status_activate;
    }

    
}