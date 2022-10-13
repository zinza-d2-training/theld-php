<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\GetCommentInPostRequest;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\Post;
use App\Services\CommentServices;
use App\Services\PostServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $commentServices;
    private $postServices;

    public function __construct(CommentServices $commentServices, PostServices $postServices)
    {
        $this->commentServices = $commentServices;
        $this->postServices = $postServices;
    }

    public function getComment(GetCommentInPostRequest $request)
    {
        $post = $this->postServices->getDetail($request->slug);
        $comments = $this->commentServices->getPostComments(data_get($post, 'id'));
        return response([
            "data" => $comments
        ], 200);
    }

    public function store(Request $request, Post $post)
    {
        $this->commentServices->storeComment($post, $request->content);

        return response([
            "message" => 'Send Comment Successfully'
        ], 200);
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
        $this->authorize('ownerPost', $comment->post);

        $resolved = Comment::where('post_id', $comment->post_id)->where('is_resolve', true)->first();
        if ($resolved){
            $resolved->update(['is_resolve' => false]);
        }
        $comment->update(['is_resolve' => !$comment->is_resolve]);

        return response([
            "message" => 'success'
        ], 200);
    }
}
