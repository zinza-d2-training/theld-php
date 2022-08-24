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
        if (Auth::user()->role_id == User::ROLE_ADMIN) {
            $users = User::with('role')
            ->where('id', '!=', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(config('constant.paginate.maxRecord'));
        }
        else {
            $users = User::with('role')
            ->where('id', '!=', Auth::id())
            ->where('company_id', Auth::user()->company->id)
            ->orderBy('id', 'desc')
            ->paginate(config('constant.paginate.maxRecord'));
        }

        return $users;
    }

    public function getCompanies()
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

    public function getRoles()
    {
        return Role::select('id', 'name')->where('id', '>', 1)->get();
    }

    public function storeUser($data)
    {
        $data['company_id'] = Auth::user()->role_id==User::ROLE_COMPANY_ACCOUNT ? Auth::user()->company->id : $data['company_id'];
        return User::create($data);
    }

    public function updateUser($data, User $user)
    {
        return $user->update($data);
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return $user->trashed();
    }
}