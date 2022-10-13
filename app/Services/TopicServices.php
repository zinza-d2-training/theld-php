<?php

namespace App\Services;

use App\Models\Topic;

class TopicServices
{
    public function getTopics()
    {
        $topics = Topic::withCount('posts')
        ->paginate(config('constant.paginate.maxRecord'));

        return $topics;
    }

    public function getAll()
    {
        return Topic::withCount('posts')->get();
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