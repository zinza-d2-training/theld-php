<?php

namespace App\Services;

use App\Models\Post;
use App\Models\Topic;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardServices
{
    public function getTopics()
    {
        if (Cache::has('dashboard')) {
            $topics = Cache::get('dashboard');
        } else {
            $topics = Topic::withCount('posts')
            ->with(['posts' => function($query) {

                return $query->with('users')
                ->whereHas('users', fn ($query) =>
                    Auth::user()->role_id != User::ROLE_ADMIN ? $query->where('company_id', '=', Auth::user()->company_id) : ''
                )
                ->withCount('comments')
                ->orderBy('is_pinned', 'desc')
                ->orderBy('id', 'desc')
                ->limit(8);
            }])
            ->withCount('comments')
            ->get();
            Cache::put('dashboard', $topics, 60);
        }
        return $topics;
    }

    public function lastestPost()
    {
        $postLimit = 5;

        $posts = Post::select(DB::raw("id, user_id, created_at, title, is_pinned, LEFT(`description`, 45) as `description`"))
        ->with('users')
        ->whereHas('users', fn ($query) =>
            Auth::user()->role_id != User::ROLE_ADMIN ? $query->where('company_id', '=', Auth::user()->company_id) : ''
        )
        ->orderBy('is_pinned', 'desc')
        ->orderBy('id', 'desc')
        ->limit($postLimit)
        ->get();

        return $posts;
    }
    

    public function getPostInTopic($topicSlug)
    {
        $topic = Topic::where('slug', $topicSlug)->first();
        $posts = null;

        if ($topic) {
            $posts = Post::where('topic_id', $topic->id)
            ->withCount('comments')
            ->whereHas('users', fn ($query) =>
                Auth::user()->role_id != User::ROLE_ADMIN ? $query->where('company_id', '=', Auth::user()->company_id) : ''
            )
            ->with('users')
            ->orderBy('is_pinned', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(config('constant.paginate.maxRecord'));
        }

        return [
            'topics' => $topic,
            'posts' => $posts
        ];
    }
    

    public function getPostBySearch($searchContent)
    {
        $posts = Post::where('title', 'LIKE', "%{$searchContent}%")
        ->orWhere('description', 'LIKE', "%{$searchContent}%")
        ->whereHas('users', fn ($query) =>
            Auth::user()->role_id != User::ROLE_ADMIN ? $query->where('company_id', '=', Auth::user()->company_id) : ''
        )
        ->withCount('comments')
        ->with('users')
        ->orderBy('is_pinned', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(config('constant.paginate.maxRecord'));

        return [
            'posts' => $posts
        ];
    }
}