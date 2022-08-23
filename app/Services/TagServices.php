<?php

namespace App\Services;

use App\Models\Tag;

class TagServices
{
    public function getTags()
    {
        $tags = Tag::orderBy('id', 'desc')->paginate(10);

        foreach ($tags as $tag) {
            $tag->countPost = $tag->posts->count();
        }
        return $tags;
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