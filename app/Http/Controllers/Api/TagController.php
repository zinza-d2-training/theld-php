<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tag\StoreTagRequest;
use App\Http\Requests\Tag\UpdateTagRequest;
use App\Models\Tag;
use App\Services\TagServices;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private $tagServices;
    
    public function __construct(TagServices $tagServices)
    {
        $this->tagServices = $tagServices;
    }

    public function getList()
    {
        $tags = $this->tagServices->getTags();

        return response([
            'data' => $tags
        ], 200);
    }

    public function getAll()
    {
        $tags = Tag::get();

        return response([
            'data' => $tags
        ], 200);
    }

    public function getOne(Tag $tag)
    {
        return response([
            'data' => $tag
        ], 200);
    }
    
    public function store(StoreTagRequest $request)
    {
        $tag = $this->tagServices->storeTag($request->input());

        return response([
            'message' => 'Create Tag Successfully',
            'data' => $tag
        ], 201);
    }
    
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $this->tagServices->updateTag($request->input(), $tag);

        return response([
            'message' => 'Update Tag successfully'
        ], 200);
    }

    public function destroy(Tag $tag)
    {
        $deleted = $this->tagServices->deleteTag($tag);

        if (!$deleted) {
            return response([
                'message' => 'Delete Tag Failed'
            ], 400);
        }

        return response([
            'message' => 'Delete Tag Successfully'
        ], 200);
    }
}
