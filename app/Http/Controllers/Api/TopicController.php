<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\GetPostsInTopic;
use App\Http\Requests\Topic\StoreTopicRequest;
use App\Http\Requests\Topic\UpdateTopicRequest;
use App\Models\Topic;
use App\Services\DashboardServices;
use App\Services\TopicServices;

class TopicController extends Controller
{
    private $topicServices;
    private $dashboardServices;
    
    public function __construct(TopicServices $topicServices, DashboardServices $dashboardServices)
    {
        $this->topicServices = $topicServices;
        $this->dashboardServices = $dashboardServices;
    }

    public function index()
    {
        $topics = $this->topicServices->getTopics();

        return response([
            'data' => $topics
        ], 200);
    }

    public function show(Topic $topic)
    {
        return response([
            "data" => $topic
        ], 200);
    }

    public function getAll()
    {
        $topics = $this->topicServices->getAll();
        return response([
            'data' => $topics
        ], 200);
    }

    public function getWithPosts(GetPostsInTopic $request)
    {
        $data = $this->dashboardServices->getPostInTopic($request->slug);
        extract($data);

        return response([
            'message' => 'success',
            'data' => [
                'topic' => $topics,
                'posts' => $posts
            ]
        ], 200);
    }
    
    public function store(StoreTopicRequest $request)
    {
        $topic = $this->topicServices->storeTopic($request->input());
        return response([
            "message" => "Create Topic Successfully",
            "data" => $topic
        ], 201);
    }
    
    public function update(UpdateTopicRequest $request, Topic $topic)
    {
        $this->topicServices->updateTopic($request->input(), $topic);
        return response([
            "message" => "Update Topic successfully"
        ], 200);
    }

    public function destroy(Topic $topic)
    {
        $deleted = $this->topicServices->deleteTopic($topic);

        if ($deleted) {
            return response([
                "message" => "Delete Topic Successfully"
            ], 200);
        }
        else {
            response([
                "message" => "Delete Topic Failed"
            ], 501);
        }
    }

}
