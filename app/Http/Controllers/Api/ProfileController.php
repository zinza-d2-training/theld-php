<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\UserController;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    private $userServices;

    public function __construct(UserServices $userServices)
    {
        $this->userServices = $userServices;
    }

    public function get()
    {
        return response([
            'data' => Auth::user()
        ], 200);
    }

    public function update(ProfileUpdateRequest $request)
    {
        $user = User::find(Auth::id());
        $request->password = Hash::make($request->new_password);

        if ($request->hasFile('avatar')) {
            $user->avatar = $this->userServices->updateAvatar($request->avatar);
        }

        $this->userServices->updateUser($request->input(), $user);
        
        return response([
            'message' => 'Update profile successfully'
        ], 201);
    }
}
