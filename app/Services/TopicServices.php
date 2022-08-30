<?php

namespace App\Services;

use App\Models\Topic;

class TopicServices
{
    public function getTopics()
    {
        $topics = Topic::withCount('posts')
        ->paginate(10);

        return $topics;
    }

    public function getAll()
    {
        return Topic::all();
    }

    public function storeTopic($data)
    {
        return Topic::create($data);
    }

    public function updateTopic($data, $topic)
    {
        return $topic->update($data);
    }

    public function deleteTopic($topic)
    {
        $topic->delete();
        return $topic->trashed();
    }
} 