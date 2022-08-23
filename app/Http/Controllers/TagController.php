<?php

namespace App\Http\Controllers;

use App\Http\Requests\Tag\StoreTagRequest;
use App\Models\Tag;
use App\Services\TagServices;

class TagController extends Controller
{
    public function __construct(TagServices $tagServices)
    {
        $this->tagServices = $tagServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->tagServices->getTags();

        return view('tag.list',[
            'tags' => $tags
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tag.form', [
            'isEditing' => false
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagRequest $request)
    {
        $this->tagServices->storeTag($request->input());

        return redirect()->route('tag.index')->withSuccess('Create Tag Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('tag.form', [
            'isEditing' => true,
            'tag' => $tag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTagRequest $request, Tag $tag)
    {
        $this->tagServices->updateTag($request->input(), $tag);

        return back()->withSuccess('Update Tag successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $deleted = $this->tagServices->deleteTag($tag);

        if ($deleted) {
            return redirect()->route('tag.index')->withSuccess('Delete Tag Successfully');
        }
        else {
            return back()->withErrors('Delete Tag Failed');
        }
    }
}
