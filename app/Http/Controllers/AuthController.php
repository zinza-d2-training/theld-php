<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckpointRequest;
use App\Http\Requests\EditPasswordFromLinkRequest;
use App\Http\Requests\SendMailRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Mail\ResetPasswordEmail;
use App\Models\Password_reset;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use function PHPUnit\Framework\isNull;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function checkpoint(CheckpointRequest $request)
    {
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return redirect()->route('home');
        } else {
            return back()->withErrors('Incorrect password');
        }
    }

    public function forgotPassword()
    {
        return view('auth.forgotPassword');
    }

    public function sendMail(SendMailRequest $request)
    {
        $emailAddress =$request->email;
        $token = Str::random(64);
        
        $oldReset = Password_reset::where('email', $emailAddress)->first();

        if (!$oldReset) {
            Password_reset::create([
                'email' => $emailAddress,
                'token' => $token
            ]);
        }
        else {
            $oldReset->token = $token;
            $oldReset->save();
        }

        $email = new ResetPasswordEmail([
            "token" => $token
        ]);
    
        Mail::to($emailAddress)->send($email);
    
        return view('auth.message', [
            'status' => true,
            'message' => 'Mail Sent Successfully! Please check your email to change your password.'
        ]);
    }

    public function editPassword(Request $request)
    {
        $expired_minutes = 15; // minutes
        $token = $request->token;
        $passwordReset = Password_reset::where('token', $token)->first();

        if (!$passwordReset || (date_diff(now(), $passwordReset->updated_at))->i >= $expired_minutes){
            return view('auth.message', [
                'status' => false,
                'message' => 'This request has expired, please create a new request'
            ]);
        }

        return view('auth.changePassword', [
            'token' => $token
        ]);
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        if ($request->password !== $request->confirm_password)
            return back()->withErrors('Confirm password not match!');

        $password_reset = Password_reset::where('token', $request->token)->first();
        $user = User::where('email', $password_reset->email)->first();

        $user->password = Hash::make($request->password);
        $user->save();

        $password_reset->token = '_';
        $password_reset->save();
        
        return redirect()->route('auth.login')->withSuccess('Your password has been changed successfully');
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('auth.login');
    }

}
