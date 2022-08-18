<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserServices extends Controller
{
    public function getUsers()
    {
        if (Auth::user()->role_id == 1) {
            $users = User::select('id', 'name', 'dob', 'status', 'role_id')
                    ->where('id', '!=', Auth::id())
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        }
        else {
            $users = User::select('users.id as id', 'users.name as name', 'users.dob as dob', 'users.status as status', 'users.role_id as role_id', 'user_companies.company_id as company_id')
                    ->join('user_companies', 'users.id', '=', 'user_companies.user_id')
                    ->where('users.id', '!=', Auth::id())
                    ->where('user_companies.company_id', '=', Auth::user()->user_company->company_id)
                    ->orderBy('id', 'desc')
                    ->paginate(10);
        }
        foreach ($users as $user)
            $user->role;

        return $users;
    }

    public function getCompanies()
    {
        if (Auth::user()->role_id==2)
            return Auth::user()->company;
        else
            return Company::select('id', 'name', 'max_user', 'expired_at', 'status')
                        ->where('expired_at', '>', now())
                        ->where('status', 1)
                        ->get();
    }

    public function getRoles()
    {
        return Role::select('id', 'name')->where('id', '>', 1)->get();
    }
}