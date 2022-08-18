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
        if ($auth->role_id == User::role_admin) {
            return true;
        }
        elseif ($auth->role_id == User::role_company_account && $user->company && $auth->company->id == $user->company->id) {
            return true;
        }

        return false;
    }
}
