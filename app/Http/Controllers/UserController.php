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
        $users = User::where('id', '!=', Auth::id())->orderBy('id', 'desc')->paginate(10);
        foreach ($users as $user) {
            $user->role;
        }
        return view('user.list',[
            'users' => $users
        ]);
    }

    public function create()
    {
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
            'company_id' => $request->company_id,
        ]);
        
        return redirect()->route('user.index')->withSuccess('Create User Successfully');
    }

    public function edit(User $user)
    {
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
        $user->save();

        $user_company = User_company::where('user_id', $user->id)->first();
        $user_company->company_id = $request->company_id;
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
