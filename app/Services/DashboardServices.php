<?php

namespace App\Services;

use App\Models\Topic;
use Illuminate\Support\Facades\Cache;

class DashboardServices
{
    public function getTopics()
    {

        if (Cache::has('dashboard')) {
            $topics = Cache::get('dashboard');
        } else {
            $topics = Topic::withCount('posts')
            ->with(['posts'=>function($query) {
                return $query->withCount('comments')
                ->with('users')
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
}