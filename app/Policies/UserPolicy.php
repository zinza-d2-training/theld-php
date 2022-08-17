<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function updateUser(User $auth, User $user)
    {
        if (!$user->user_company)
            return false;

        if ($auth->id == $user->id)
            return false;
        if ($auth->role_id == 1)
            return true;
        elseif ($auth->role_id == 2 && $auth->user_company->company_id == $user->user_company->company_id)
            return true;

        return false;
    }
}
