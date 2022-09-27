<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use App\Rules\adminAndCA;
use App\Services\CommentServices;
use App\Services\DashboardServices;
use App\Services\PostServices;
use App\Services\TopicServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    private $topicServices;
    private $postServices;
    private $dashboardServices;
    private $commentServices;

    public function __construct(TopicServices $topicServices, PostServices $postServices, DashboardServices $dashboardServices, CommentServices $commentServices)
    {
        $this->topicServices = $topicServices;
        $this->postServices = $postServices;
        $this->dashboardServices = $dashboardServices;
        $this->commentServices = $commentServices;
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

    public function postDetail(Request $request)
    {
        $post = $this->dashboardServices->getPostDetail($request->slug);
        $comments = $this->commentServices->getPostComments(data_get($post, 'id'));
        $isAdminCA = $this->dashboardServices->CheckAdminAndCA($post->users->company_id);
        $isOwner = $post->users->id == Auth::id();

        return view('dashboard.postDetail', [
            'post' => $post,
            'comments' => $comments,
            'isAdminCA' => $isAdminCA,
            'isOwner' => $isOwner
        ]);
    }
}
