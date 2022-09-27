<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function updatePost($auth , $post)
    {
        if ($auth->id == $post->user_id || $auth->role_id == User::ROLE_ADMIN || ($auth->role_id == User::ROLE_COMPANY_ACCOUNT && $auth->company_id == $post->users->company_id)) {
            return true;
        }
        return false;
    }
}
