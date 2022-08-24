<?php

namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\InvokableRule;
use Illuminate\Support\Facades\Auth;

class adminAndCA implements InvokableRule
{
    public function __construct($request_company_id)
    {
        $this->request_company_id = $request_company_id;
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
        if (!( Auth::user()->role_id == User::ROLE_ADMIN || (Auth::user()->role_id == User::ROLE_COMPANY_ACCOUNT && Auth::user()->company_id == $this->request_company_id)) ){
            $fail('Only Admin and Company Account can edit :attribute');
        }
    }
}
