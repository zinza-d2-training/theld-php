<?php

namespace App\Http\Controllers;

use App\Actions\UserActions;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Models\User_company;
use App\Services\UserServices;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct(UserServices $userServices, UserActions $userActions)
    {
        $this->userServices = $userServices;
        $this->userActions = $userActions;
    }

    public function index()
    {
        $users = $this->userServices->getUsers();

        return view('user.list',[
            'users' => $users
        ]);
    }

    public function create()
    {
        $companies = $this->userServices->getCompanies();
        $roles = $this->userServices->getRoles();

        return view('user.form', [
            'isEditing' => false,
            'roles' => $roles,
            'companies' => $companies
        ]);
    }

    public function store(StoreUserRequest $request)
    {
        $user = $this->userActions->storeUser($request);
        $this->userActions->storeUserCompany($request, $user);
        
        return redirect()->route('user.index')->withSuccess('Create User Successfully');
    }

    public function edit(User $user)
    {
        $user->company = $user->company[0];
        $companies = $this->userServices->getCompanies();
        $roles = $this->userServices->getRoles();

        return view('user.form', [
            'isEditing' => true,
            'user' => $user,
            'roles' => $roles,
            'companies' => $companies
        ]);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userActions->updateUser($request, $user);
        $this->userActions->updateUserCompany($request, $user);

        return back()->withSuccess('Update profile successfully');
    }

    public function delete(User $user)
    {
        $deleted = $this->userActions->deleteUser($user);

        if ($deleted)
            return redirect()->route('user.index')->withSuccess('Delete User Successfully');
        else 
            return back()->withErrors('Delete User Failed');
    }
}
