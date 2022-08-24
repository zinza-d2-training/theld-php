<?php

namespace App\Services;

use App\Models\Topic;

class TopicServices
{
    public function getTopics()
    {
        $topics = Topic::orderBy('id', 'desc')->paginate(10);

        foreach ($topics as $topic) {
            $topic->countPost = $topic->posts->count();
        }
        return $topics;
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