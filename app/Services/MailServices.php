<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Mail\BirthdayMail;
use App\Mail\DeletePost;
use App\Mail\DeletePostMail;
use App\Mail\NewUserMail;
use App\Mail\ResetPasswordEmail;
use Illuminate\Support\Facades\Mail;

class MailServices extends Controller
{
    public function sendMailResetPassword($emailAddress, $token)
    {
        $email = new ResetPasswordEmail([
            "token" => $token
        ]);
    
        Mail::to($emailAddress)->send($email);
    }

    public function sendMailNewUser($emailAddress, $data)
    {
        $email = new NewUserMail([
            'email' => $data['email'],
            'name' => $data['name']
        ]);
    
        Mail::to($emailAddress)->send($email);
    }

    public static function sendMailBirthday($emailAddress, $name)
    {
        $email = new BirthdayMail([
            'name' => $name,
        ]);
    
        Mail::to($emailAddress)->send($email);
    }

    public static function sendMaildeletePost($user, $data)
    {
        $email = new DeletePostMail([
            'user' => $user,
            'post' =>$data
        ]);
    
        Mail::to($user->email)->send($email);
    }
}