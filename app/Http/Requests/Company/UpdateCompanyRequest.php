<?php

namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
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
            'name' => ['required', 'min:4', 'unique:companies,name,' . $this->company->id],
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif',
            'address' => 'nullable|min:0|max:190',
            'max_user' => 'numeric|min:0',
            'expired_at' => 'date',
            'status' => 'numeric|min:0'
        ];
    }
}
