<?php

namespace App\Services;

use App\Models\PasswordReset;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthServices {
    public function createNewTokenReset($emailAddress)
    {
        $token = Str::random(64);

        PasswordReset::updateOrCreate(
            ['email' => $emailAddress],
            ['token' => $token]
        );
        return $token;
    }

    public function sendMailReset($emailAddress, $token)
    {
        $email = new ResetPasswordEmail([
            "token" => $token
        ]);
    
        Mail::to($emailAddress)->send($email);
    }

    public function isAliveToken($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();
        if ($passwordReset && (date_diff(now(), $passwordReset->updated_at))->i < PasswordReset::token_expired_minutes) {
            return true;
        }
        else {
            $passwordReset ? $passwordReset->delete() : '';
            return false;
        }
    }
}