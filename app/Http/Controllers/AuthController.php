<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckpointRequest;
use App\Http\Requests\SendMailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\AuthServices;
use App\Services\CompanyServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct(AuthServices $authServices, CompanyServices $companyServices)
    {
        $this->authServices = $authServices;
        $this->companyServices = $companyServices;
    }


    public function index()
    {
        return view('auth.login');
    }


    public function checkpoint(CheckpointRequest $request)
    {
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return back()->withErrors('Incorrect password');
        }
        if (!$this->companyServices->isActivate(Auth::user()->company_id)){
            session(['message' => 'Your company has been expired']);
            return redirect()->route('auth.logout');
        }
        return redirect()->route('home');
    }


    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }


    public function sendMail(SendMailRequest $request)
    {
        if (!User::where('email', $request->email)->first()){
            return back()->withErrors('Your account has been blocked');
        }

        $token = $this->authServices->createNewTokenReset($request->email);
        $this->authServices->sendMailReset($request->email, $token);
    
        return view('auth.message', [
            'status' => true,
            'message' => 'Mail Sent Successfully! Please check your email to change your password.'
        ]);
    }


    public function editPassword(Request $request)
    {
        if ($this->authServices->isAliveToken($request->token)){
            return view('auth.changePassword', [
                'token' => $request->token
            ]);
        }

        return view('auth.message', [
            'status' => false,
            'message' => 'This request has expired, please create a new request'
        ]);
    }


    public function updatePassword(UpdatePasswordRequest $request)
    {
        $password_reset = PasswordReset::where('token', $request->token)->first();
        $user = $password_reset->user;

        $user->password = Hash::make($request->password);
        $user->save();

        $password_reset->delete();
        
        return redirect()->route('auth.login')->withSuccess('Your password has been changed successfully');
    }


    public function logout(Request $request)
    {
        $message = $request->session()->get('message');
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        if ($message) {
            return view('auth.message', [
                'status' => false,
                'message' => $message
            ]);
        }
        return redirect()->route('auth.login');
    }
}
