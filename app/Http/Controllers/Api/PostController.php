<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\GetPostDetail as PostGetPostDetail;
use App\Http\Requests\Post\GetPostsInTopic;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Services\CommentServices;
use App\Services\DashboardServices;
use App\Services\MailServices;
use App\Services\PostServices;
use App\Services\TagServices;
use App\Services\TopicServices;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class PostController extends Controller
{
    private $postServices;
    private $topicServices;
    private $tagServices;
    private $mailServices;
    private $dashboardServices;
    private $commentServices;

    public function __construct(
        PostServices $postServices, 
        DashboardServices $dashboardServices, 
        TopicServices $topicServices, 
        TagServices $tagServices, 
        MailServices $mailServices,
        CommentServices $commentServices
    )
    {
        $this->postServices = $postServices;
        $this->topicServices = $topicServices;
        $this->tagServices = $tagServices;
        $this->mailServices = $mailServices;
        $this->dashboardServices = $dashboardServices;
        $this->commentServices = $commentServices;
    }
    
    public function index()
    {
        $posts = $this->postServices->getPosts();

        return response([
            'data' => $posts,
        ], 200);
    }
    
    public function detail(PostGetPostDetail $request)
    {
        $post = $this->postServices->getDetail($request->slug);

        return response([
            'message' => 'success',
            'data' => $post
        ], 200);
    }

    public function getLastestPost()
    {
        $lastestPosts = $this->dashboardServices->lastestPost();
        return response([
            'data' => $lastestPosts
        ], 200);
    }

    public function getDataCreate()
    {
        $topics = $this->topicServices->getall();
        $tags = $this->tagServices->getall();

        return response([
            "data" => [
                "topics" => $topics,
                "tags" => $tags
            ]
        ], 200);
    }
    
    public function store(StorePostRequest $request)
    {
        $this->postServices->storePost($request);
        return response([
            'message' => 'Create Post Successfully',
        ], 201);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $updated = $this->postServices->updatePost($request, $post);
        return response([
            'message' => 'Update Post Successfully'
        ], 200);
    }
    
    public function destroy(Post $post)
    {
        $deleted = $this->postServices->deletePost($post);

        if (!$deleted) {
            return response([
               'message' => 'Delete post Failed'
            ], 500);
        }
        
        if (Auth::user()->id !== $post->users->id) {
            $this->mailServices->sendMaildeletePost($post->users, $post);
        }
        return response([
            'message' => 'Delete Post Successfully'
        ], 200);
    }
}
