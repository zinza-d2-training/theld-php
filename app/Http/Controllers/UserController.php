<?php

namespace App\Http\Controllers;

use App\Services\userServices;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Models\UserCompany;
use App\Services\MailServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    private $userServices;
    private $mailServices;

    public function __construct(UserServices $userServices, MailServices $mailServices)
    {
        $this->userServices = $userServices;
        $this->mailServices = $mailServices;
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
        $this->userServices->storeUser($request->input());
        $this->mailServices->sendMailNewUser($request->email, $request->input());

        return redirect()->route('user.index')->withSuccess('Create User Successfully');
    }

    public function edit(User $user)
    {
        $user->company;
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
        $this->userServices->updateUser($request->input(), $user);
        return back()->withSuccess('Update profile successfully');
    }

    public function delete(User $user)
    {
        $deleted = $this->userServices->deleteUser($user);

        if ($deleted) {
            return redirect()->route('user.index')->withSuccess('Delete User Successfully');
        }
        else {
            return back()->withErrors('Delete User Failed');
        }
    }
}
