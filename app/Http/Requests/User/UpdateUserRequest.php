<?php

namespace App\Http\Requests\User;

use App\Models\User;
use App\Rules\Admin;
use GuzzleHttp\Psr7\Request;
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
            'name' => 'string|min:5|max:100',
            'email' => ['email', 'unique:Users,email,' . $this->user->id, new Admin],
            'role_id' => 'exists:Roles,id',
            'company_id' => '|integer|exists:Companies,id',
            'dob' => 'nullable|date',
            'status' => 'integer|min:0|max:1'
        ];
    }
}
