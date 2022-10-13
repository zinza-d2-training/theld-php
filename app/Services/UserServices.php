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
            ->with('company')
            ->where('id', '!=', Auth::id())
            ->orderBy('role_id', 'asc')
            ->orderBy('company_id', 'asc')
            ->orderBy('id', 'desc')
            ->paginate(config('constant.paginate.maxRecord'));
        }
        else {
            $users = User::with('role')
            ->with('company')
            ->where('id', '!=', Auth::id())
            ->where('company_id', Auth::user()->company->id)
            ->orderBy('role_id', 'asc')
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

    public function isExistsEmail($email)
    {
        return User::where('email', 'like', $email)->first() ? true : false;
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

    public function deleteUser($ids)
    {
        try {
            $ids = explode("|", $ids);
            $process = [];

            $users = User::whereIn('id', $ids)
            ->where('id', '!=', Auth::id())
            ->where('role_id', '!=', User::ROLE_ADMIN)
            ->where(function($query){
                if (Auth::user()->role_id == User::ROLE_COMPANY_ACCOUNT) {
                    $query->where('company_id', Auth::user()->company_id);
                }
            })
            ->get();

            foreach ($users as $user) {
                $user->delete();
                $process[$user->id]= $user->trashed();
            }
            return $process;
        } catch (\Throwable $th) {
            return $th;
        }
        
    }

    public function updateAvatar($image)
    {
        $fileName = $image->hashName();
        return $image->storeAs('images/user', $fileName);
    }
}