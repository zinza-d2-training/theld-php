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
        if ($auth->id == $user->id) {
            return false;
        }
        if ($auth->role_id == User::ROLE_ADMIN) {
            return true;
        }
        elseif ($auth->role_id == User::ROLE_COMPANY_ACCOUNT && $user->company && $auth->company->id == $user->company->id) {
            return true;
        }

        return false;
    }
}
