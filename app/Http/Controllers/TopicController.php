<?php

namespace App\Http\Controllers;

use App\Http\Requests\Topic\StoreTopicRequest;
use App\Models\Tag;
use App\Models\Topic;
use App\Services\TopicServices;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    private $topicServices;
    
    public function __construct(TopicServices $topicServices)
    {
        $this->topicServices = $topicServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = $this->topicServices->getTopics();

        return view('topic.list',[
            'topics' => $topics
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('topic.form', [
            'isEditing' => false
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTopicRequest $request)
    {
        $this->topicServices->storeTopic($request->input());
        return redirect()->route('topic.index')->withSuccess('Create Topic Successfully');
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
    public function edit(Topic $topic)
    {
        return view('topic.form', [
            'isEditing' => true,
            'topic' => $topic,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreTopicRequest $request, Topic $topic)
    {
        $this->topicServices->updateTopic($request->input(), $topic);
        return back()->withSuccess('Update Topic successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topic $topic)
    {
        $deleted = $this->topicServices->deleteTopic($topic);

        if ($deleted) {
            return redirect()->route('topic.index')->withSuccess('Delete Topic Successfully');
        }
        else {
            return back()->withErrors('Delete Topic Failed');
        }
    }
}
