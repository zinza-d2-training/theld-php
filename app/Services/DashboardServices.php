<?php

namespace App\Services;

use App\Models\Comment;
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
                ->withCount('comments')
                ->orderBy('is_pinned', 'desc')
                ->orderBy('id', 'desc')
                ->limit(8);
            }])
            ->withCount('comments')
            ->get();
            Cache::put('dashboard', $topics, 30);
        }
        return $topics;
    }

    public function lastestPost()
    {
        $postLimit = 5;

        $posts = Post::select(DB::raw("id, user_id, created_at, title, is_pinned, LEFT(`description`, 45) as `description`"))
        ->with('users')
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
        ->withCount('comments')
        ->with('users')
        ->orderBy('is_pinned', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(config('constant.paginate.maxRecord'));

        return [
            'posts' => $posts
        ];
    }
     
    public function getPostDetail($slug)
    {
        $post = Post::where('slug', $slug)
        ->with('users')->with('tags')->first();

        return $post;
    }

    public static function CheckAdminAndCA($request_company_id)
    {
        return (Auth::user()->role_id == User::ROLE_ADMIN || (Auth::user()->role_id == User::ROLE_COMPANY_ACCOUNT && Auth::user()->company_id == $request_company_id) );
    }
}