<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
            'old_password' => 'nullable|max:50',
            'new_password' => 'nullable|min:5|max:50',
            'confirm_new_password' => 'nullable|min:5|max:50',
            'avatar' => 'nullable|mimes:jpeg,jpg,png,gif'
        ];
    }
}
