<?php

namespace App\Actions;

use App\Models\User;
use App\Models\User_company;
use Illuminate\Support\Facades\Auth;

class UserActions{
    public function storeUser($request)
    {
        return User::create([
            'email' => $request->email,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'dob' => $request->dob,
            'password' => ''
        ]);
    }

    public function storeUserCompany($request, User $user)
    {
        return User_company::create([
            'user_id' => $user->id,
            'company_id' => Auth::user()->role_id==2 ? Auth::user()->user_company->company_id : $request->company_id,
        ]);
    }

    public function updateUser($request, User $user)
    {
        $user->name = $request->name ;
        $user->dob = $request->dob;
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        return $user->save();
    }

    public function updateUserCompany($request, User $user)
    {
        $user_company = User_company::where('user_id', $user->id)->first();
        $user_company->company_id = Auth::user()->role_id==2 ? Auth::user()->user_company->company_id : $request->company_id;
        return $user_company->save();
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        $user->user_company->delete();

        return $user->trashed();
    }
}