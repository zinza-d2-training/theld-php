<?php

namespace App\Http\Controllers;

use App\Services\DashboardServices;
use App\Services\PostServices;
use App\Services\TopicServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function __construct(TopicServices $topicServices, PostServices $postServices, DashboardServices $dashboardServices)
    {
        $this->topicServices = $topicServices;
        $this->postServices = $postServices;
        $this->dashboardServices = $dashboardServices;
    }
    
    public function index()
    {
        $topics = $this->dashboardServices->getTopics();

        return view('dashboard.index', [
            'topics' => $topics,
        ]);
    }

    public function topicDetail(Request $request)
    {
        $data = $this->dashboardServices->getPostInTopic($request->slug);
        extract($data);

        return view('dashboard.list', [
            'is_searching' => false,
            'topic' => $topics,
            'posts' => $posts
        ]);
    }

    public function search(Request $request)
    {
        $data = $this->dashboardServices->getPostBySearch($request->search);
        extract($data);

        return view('dashboard.list', [
            'is_searching' => true,
            'posts' => $posts
        ]);
    }
}
