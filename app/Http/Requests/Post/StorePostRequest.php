<?php

namespace App\Http\Requests\Post;

use App\Rules\Admin;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title' => 'required|min:5',
            'description' => 'required',
            'topic_id' => 'required|exists:topics,id',
            'status' => ['nullable', new Admin]
        ];
    }
}
