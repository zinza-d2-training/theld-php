<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CommentServices;
use App\Services\DashboardServices;
use App\Services\PostServices;
use App\Services\TopicServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private $dashboardServices;

    public function __construct(TopicServices $topicServices, PostServices $postServices, DashboardServices $dashboardServices, CommentServices $commentServices)
    {
        $this->topicServices = $topicServices;
        $this->postServices = $postServices;
        $this->dashboardServices = $dashboardServices;
        $this->commentServices = $commentServices;
    }

    public function getAll()
    {
        $topics = $this->dashboardServices->getTopics();

        return response([
            'message' => 'success',
            'data' => $topics
        ], 200);
    }

    public function search(Request $request)
    {
        $posts = $this->dashboardServices->getPostBySearch($request->content);

        return response([
            'message' => 'success',
            'data' => $posts
        ]);
    }

    public function getChartData()
    {
        $data = $this->dashboardServices->getChartData();
    }
}
