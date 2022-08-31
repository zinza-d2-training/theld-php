<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentServices
{
    public function storeComment($post, $content)
    {
        Comment::create([
            'post_id' => $post->id,
            'content' => $content,
            'user_id' => Auth::id()
        ]);
    }

    public function getPostComments($post_id)
    {
        $comments = Comment::where('post_id', $post_id)
        ->withCount('reactions')
        ->withExists(['reactions' => function($query) {
                return $query->where('user_id', Auth::id());
            }
        ])
        ->orderBy('is_resolve', 'desc')
        ->orderBy('reactions_count', 'desc')
        ->orderBy('id', 'desc')
        ->paginate(10);

        return $comments;
    }
}