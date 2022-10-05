<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\CheckEmailExistRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Services\MailServices;
use App\Services\UserServices;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userServices;
    private $mailServices;

    public function __construct(UserServices $userServices, MailServices $mailServices)
    {
        $this->userServices = $userServices;
        $this->mailServices = $mailServices;
    }

    public function get()
    {
        $users = $this->userServices->getUsers();

        return response([
            'data' => $users
        ], 200);
    }

    public function getOne(User $user)
    {
        $user->company;
        $user->role;

        return response([
            'data' => $user
        ], 200);
    }

    public function emailExists(CheckEmailExistRequest $request)
    {
        $isExists = $this->userServices->isExistsEmail($request->email);
        return response([
            'result' => $isExists
        ], 200);
    }

    public function store(StoreUserRequest $request)
    {
        $this->userServices->storeUser($request->input());
        $this->mailServices->sendMailNewUser($request->email, $request->input());

        return response([
            'message' => 'Create User Successfully'
        ], 201);
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->userServices->updateUser($request->input(), $user);
        
        return response([
            'message' => 'Update user successfully'
        ], 201);
    }

    public function delete($id)
    {
        $process = $this->userServices->deleteUser($id);

        return response([
            'process' => $process
        ], 200);
    }

    public function getRoles()
    {
        $roles = $this->userServices->getRoles();
        return response([
            'data' => $roles
        ], 200);
    }
}
