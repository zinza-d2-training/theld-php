<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class storeComment
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct($auth , $post)
    {
        if ($auth->role_id == User::ROLE_ADMIN || $auth->company_id == $post->users->company_id) {
            return true;
        }
        return false;
    }
}
