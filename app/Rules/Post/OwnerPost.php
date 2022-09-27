<?php

namespace App\Rules\Post;

use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Auth;

class OwnerPost implements InvokableRule
{
    public function __construct($post_user_id)
    {
        $this->post_user_id = $post_user_id;
    }

    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        if (Auth::id() != $this->post_user_id){
            $fail('Only owner can edit :attribute');
        }
    }
}
