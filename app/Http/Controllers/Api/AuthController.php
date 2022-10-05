<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ValidResetTokenRequest;
use App\Http\Requests\CheckpointRequest;
use App\Http\Requests\SendMailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\AuthServices;
use App\Services\CompanyServices;
use App\Services\MailServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    private $authServices;
    private $companyServices;
    private $mailServices;

    public function __construct(AuthServices $authServices, CompanyServices $companyServices, MailServices $mailServices)
    {
        $this->authServices = $authServices;
        $this->companyServices = $companyServices;
        $this->mailServices = $mailServices;
    }
    
    public function checkpoint(CheckpointRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response([
                'message' => 'Incorrect password',
            ], 401);
        }

        if (Auth::user()->status == 0){
            return response([
                'message' => 'Your account is not activate',
            ], 401);
        }

        if (!$this->companyServices->isActivate(Auth::user()->company_id)){
            return response([
                'message' => 'Your company has been expired',
            ], 401);
        }
        $token = Auth::user()->createToken('API TOKEN')->plainTextToken;

        return response([
            'token' => $token
        ], 200);
    } 

    public function sendMail(SendMailRequest $request)
    {
        if (!User::where('email', $request->email)->first()){
            return response([
                'message' => 'Your account has been blocked'
            ], 401);
        }

        $token = $this->authServices->createNewTokenReset($request->email);
        $this->mailServices->sendMailResetPassword($request->email, $token);
    
        return response([
            'message' => 'Mail Sent Successfully! Please check your email to change your password.'
        ], 200);
    }

    public function validResetToken(ValidResetTokenRequest $request)
    {
        $password_reset = PasswordReset::where('token', $request->token)->first();

        if (!$password_reset) {
            return response([
                'result' => false
            ], 200);
        }

        return response([
            'result' => true
        ], 200);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        $password_reset = PasswordReset::where('token', $request->token)->first();
        $user = $password_reset->user;

        $user->password = Hash::make($request->password);
        $user->save();

        $password_reset->delete();
        
        return response([
            'message' => 'Your password has been changed successfully'
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response([
            'message' => 'revoke token successfully'
        ], 200);
    }
}
