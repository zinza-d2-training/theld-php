<?php

namespace App\Http\Requests\User;

use App\Rules\admin;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required',
            'email' => ['required', 'email', 'unique:Users,email', new admin],
            'role_id' => 'required|exists:Roles,id',
            'company_id' => 'required|integer|exists:Companies,id',
            'dob' => 'nullable|date',
            'status' => 'required|integer|min:0|max:1'
        ];
    }
}
