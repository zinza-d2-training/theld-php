<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', [
            'user' => $user
        ]);
    }


    public function update(ProfileUpdateRequest $request)
    {
        $oldUser = User::find(Auth::id());

        $oldUser->name = $request->name;
        $oldUser->dob = $request->dob;

        if ($request->hasFile('avatar')) {
            $fileName = $request->avatar->hashName();
            $oldUser->avatar = $request->avatar->storeAs('images/user', $fileName);
        }

        if ($request->old_password || $request->new_password || $request->confirm_new_password) {
            if (!Hash::check($request->old_password, $oldUser->password)) {
                return back()->withErrors('Wrong old password');
            }

            $oldUser->password = Hash::make($request->new_password);
        }
        $oldUser->save();
        return back()->withSuccess('Update profile successfully');
    }
}
