<?php

namespace App\Http\Controllers;

use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Services\MailServices;
use App\Services\PostServices;
use App\Services\TagServices;
use App\Services\TopicServices;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct(PostServices $postServices, TopicServices $topicServices, TagServices $tagServices, MailServices $mailServices)
    {
        $this->postServices = $postServices;
        $this->topicServices = $topicServices;
        $this->tagServices = $tagServices;
        $this->mailServices = $mailServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = $this->postServices->getPosts();

        return view('post.list',[
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $topics = $this->topicServices->getall();
        $tags = $this->tagServices->getall();

        return view('post.form', [
            'isEditing' => false,
            'topics' => $topics,
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $this->postServices->storePost($request);
        return redirect()->route('post.index')->withSuccess('Create Post Successfully');
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
    public function edit(Post $post)
    {
        $topics = $this->topicServices->getall();
        $tags = $this->tagServices->getall();

        $tags_selected = $post->tags->toArray();
        $tags_selected = array_map(fn ($v) => $v['id'] , $tags_selected);

        return view('post.form', [
            'isEditing' => true,
            'post' => $post,
            'topics' => $topics,
            'tags' => $tags,
            'tags_selected' => $tags_selected
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $updated = $this->postServices->updatePost($request, $post);
        return back()->withSuccess('Update Post Successfully');
    }

    /**pos
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $deleted = $this->postServices->deletePost($post);
        
        if (Auth::user()->id !== $post->users->id) {
            $this->mailServices->sendMaildeletePost($post->users, $post);
        }

        if (!$deleted) {
            return back()->withErrors('Delete post Failed');
        }
        return redirect()->route('post.index')->withSuccess('Delete Post Successfully');
    }
}
