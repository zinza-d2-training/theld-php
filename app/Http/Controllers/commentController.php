<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Post;
use App\Services\CommentServices;
use App\Services\DashboardServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class commentController extends Controller
{
    private $commentServices;
    private $dashboardServices;

    public function __construct(DashboardServices $dashboardServices, CommentServices $commentServices)
    {
        $this->commentServices = $commentServices;
        $this->dashboardServices = $dashboardServices;
    }

    public function store(Request $request, Post $post)
    {
        $this->commentServices->storeComment($post, $request->content);

        return back()->withSuccess('Send Comment Successfully');
    }

    public function reaction(Request $request)
    {
        if ($reaction = CommentReaction::where('comment_id', $request->id)->where('user_id', Auth::id())->first()){
            $reaction->delete();
        }
        else {
            CommentReaction::create([
                'comment_id' => $request->id,
                'user_id' => Auth::id()
            ]);
        }
        return response('success', 200);
    }

    public function resolved(Comment $comment)
    {
        $resolved = Comment::where('post_id', $comment->post_id)->where('is_resolve', true)->first();
        if ($resolved){
            $resolved->update(['is_resolve' => false]);
        }
        $comment->update(['is_resolve' => !$comment->is_resolve]);

        return back();
    }
}
