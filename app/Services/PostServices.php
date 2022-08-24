<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PostServices extends Controller
{
    public function getPosts()
    {
        if (Auth::user()->role_id == User::ROLE_ADMIN) {
            $posts = Post::orderBy('id', 'desc')
            ->paginate(10);
        }
        elseif (Auth::user()->role_id == User::ROLE_COMPANY_ACCOUNT) {
            $posts = Post::with('users')
            ->whereHas('users', fn ($query) =>
                $query->where('company_id', '=', Auth::user()->company_id)
            )
            ->orderBy('id', 'desc')
            ->paginate(10);
        }
        else {
            $posts = Post::with('users')
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc')
            ->paginate(10);
        }
        return $posts;
    }

    public function getRoles()
    {
        return Role::select('id', 'name')->where('id', '>', 1)->get();
    }

    public function storeUser($data)
    {
        $data['company_id'] = Auth::user()->role_id==User::ROLE_ADMIN ? Auth::user()->company->id : $data['company_id'];
        return User::create($data);
    }

    public function updateUser($data, User $user)
    {
        return $user->update($data);
    }

    public function deleteUser(User $user)
    {
        $user->delete();
        return $user->trashed();
    }
}