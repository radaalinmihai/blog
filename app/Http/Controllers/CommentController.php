<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Like;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        $comment = new Comment($this->validateComment());
        $comment->user_id = Auth::id();
        $comment->post_id = request()->id;
        $comment->save();
        return redirect(route('post', request()->id))->with('message', 'Comment posted!');
    }

    public function like(Comment $comment)
    {
        $comment->like(request()->id);
        return ['liked' => true];
    }

    public function dislike(Comment $comment)
    {
        $comment->dislike(request()->id);
        return ['liked' => false];
    }

    protected function validateComment()
    {
        return request()->validate([
            'body' => 'required'
        ]);
    }
}
