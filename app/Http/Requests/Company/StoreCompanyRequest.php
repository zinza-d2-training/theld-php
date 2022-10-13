<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'name' => 'required|min:5|max:100|unique:Companies,name',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'address' => 'nullable|max:250',
            'max_user' => 'required|numeric|min:0|max:999999',
            'expired_at' => 'required|date',
            'status' => 'numeric|min:0'
        ];
    }
}
