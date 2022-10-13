<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|min:5|max:100',
            'email' => 'required|email|unique:Users,email',
            'role_id' => 'required|exists:Roles,id|integer|min:2',
            'company_id' => 'required|integer|exists:Companies,id',
            'dob' => 'nullable|date'
        ];
    }
}
