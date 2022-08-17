<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use App\Models\User_company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
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
        foreach ($users as $user) {
            $user->role;
        }

        return view('user.list',[
            'users' => $users
        ]);
    }

    public function create()
    {
        if (Auth::user()->role_id==2)
            $companies = Auth::user()->company;
        else
            $companies = Company::select('id', 'name', 'max_user', 'expired_at', 'status')
                        ->where('expired_at', '>', now())
                        ->where('status', 1)
                        ->get();

        $roles = Role::select('id', 'name')->where('id', '>', 1)->get();
        return view('user.form', [
            'isEditing' => false,
            'roles' => $roles,
            'companies' => $companies
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'email' => $request->email,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'dob' => $request->dob,
            'password' => ''
        ]);
        User_company::create([
            'user_id' => $user->id,
            'company_id' => Auth::user()->role_id==2 ? Auth::user()->user_company->company_id : $request->company_id,
        ]);
        
        return redirect()->route('user.index')->withSuccess('Create User Successfully');
    }

    public function edit(User $user)
    {
        if (Auth::user()->role_id==2)
            $companies = Auth::user()->company;
        else
            $companies = Company::select('id', 'name', 'max_user', 'expired_at', 'status')
                        ->where('expired_at', '>', now())
                        ->where('status', 1)
                        ->get();
        $roles = Role::select('id', 'name')->where('id', '>', 1)->get();
        $user->company = $user->company[0];
        return view('user.form', [
            'isEditing' => true,
            'user' => $user,
            'roles' => $roles,
            'companies' => $companies
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->name = $request->name ;
        $user->dob = $request->dob;
        $user->role_id = $request->role_id;
        $user->status = $request->status;
        $user->save();

        $user_company = User_company::where('user_id', $user->id)->first();
        $user_company->company_id = Auth::user()->role_id==2 ? Auth::user()->user_company->company_id : $request->company_id;
        $user_company->save();

        return back()->withSuccess('Update profile successfully');
    }

    public function delete(User $user)
    {
        $user->delete();
        if ($user->trashed()) {
            return redirect()->route('user.index')->withSuccess('Delete User Successfully');
        }
    }
}
