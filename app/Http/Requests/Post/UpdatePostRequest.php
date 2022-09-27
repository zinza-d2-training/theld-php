<?php

namespace App\Http\Requests\Post;

use App\Rules\Admin;
use App\Rules\adminAndCA;
use App\Rules\Post\OwnerPost;
use App\Rules\Post\SelfPost;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
            'title' => ['', 'min:5', new OwnerPost($this->post->user_id)],
            'description' => ['required', 'min:1', new OwnerPost($this->post->user_id)],
            'topic_id' => '|exists:topics,id',
            'tags' => ['nullable'],
            'status' => ['integer', 'min:-1', 'max:2', new adminAndCA($this->post->users->company_id)]
        ];
    }
}
