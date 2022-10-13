<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ' required|string|min:5|max:100',
            'old_password' => [
                'nullable',
                'max:50',
                function ($attribute, $value, $fail) {
                    $user = User::find(Auth::id());
                    if (!Hash::check($value, $user->password)) {
                        $fail('Wrong old password');
                    }
                },
            ],
            'new_password' => 'nullable|min:5|max:50|required_unless:old_password,null',
            'confirm_new_password' => 'nullable|min:5|max:50|same:new_password',
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif'
        ];
    }
}
