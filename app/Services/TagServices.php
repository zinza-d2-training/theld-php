<?php

namespace App\Services;

use App\Models\PostTag;
use App\Models\Tag;

class TagServices
{
    public function getTags()
    {
        $tags = Tag::orderBy('id', 'desc')
        ->withCount('posts')
        ->paginate(10);

        return $tags;
    }

    public function getAll()
    {
        return Tag::all();
    }

    public function storeTag($data)
    {
        return Tag::create($data);
    }

    public function updateTag($data, $tag)
    {
        return $tag->update($data);
    }

    public function deleteTag($tag)
    {
        $tag->delete();
        return $tag->trashed();
    }
}