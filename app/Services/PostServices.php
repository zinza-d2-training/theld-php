<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostServices extends Controller
{
    public function getPosts()
    {
        if (Auth::user()->role_id == User::ROLE_ADMIN) {
            $posts = Post::with('tags')->with('users')
            ->withExists(['comments' => function($query) {
                return $query->where('is_resolve', true);
            }])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(config('constant.paginate.maxRecord'));
        }
        elseif (Auth::user()->role_id == User::ROLE_COMPANY_ACCOUNT) {
            $posts = Post::with('tags')->with('users')
            ->whereHas('users', fn ($query) =>
                $query->where('company_id', '=', Auth::user()->company_id)
            )
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(config('constant.paginate.maxRecord'));
        }
        else {
            $posts = Post::with('users')
            ->where('user_id', Auth::id())
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(config('constant.paginate.maxRecord'));
        }
        return $posts;
    }

    public function getDetail($slug)
    {
        return Post::where('slug', $slug)->with('users')->withCount('comments')->with('tags')->first();
    }

    public function storePost($request)
    {
        $data = $request->input();
        $data['user_id'] = Auth::id();
        $data['status'] =  Auth::user()->role_id == User::ROLE_MEMBER ? Post::STATUS_WAITING : Post::STATUS_DESOLVED;

        $data['tags'] ? $tags = explode(",", $data['tags']) : '';
        unset($data['tags']);

        $post = Post::create($data);

        isset($tags) ? $this->storePostTags($post->id, $tags) : '';

        return true;
    }

    public function storePostTags($post_id, $tags)
    {
        foreach ($tags as $tag_id) {
            PostTag::create([
                'post_id' => $post_id,
                'tag_id' => $tag_id
            ]);
        }
        return;
    }

    public function updatePost($request, $post)
    {
        $data = $request->input();

        if (data_get($data, 'tags')) {
            $tags = explode(",", $data['tags']);
            unset($data['tags']);
        }
        if (Auth::user()->role_id == config('constant.role.member')) {
            $data['status'] = 0;
        }

        $p = $post->update($data);

        $post->postTags()->delete();
        isset($tags) ? $this->storePostTags($post->id, $tags) : '';

        return true;
    }

    public function deletePost($post)
    {
        $post->delete();
        return $post->trashed();
    }
}