<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', [
            'except' => ['index', 'show']
        ]);
    }

    public function index()
    {
        $posts = Post::latest()->get();
        return view('home', compact('posts'));
    }

    public function create()
    {
        return view('create');
    }

    public function store()
    {
        $post = new Post($this->validatePost());
        $post->user_id = Auth::user()->id;
        $post->save();
        return redirect('/')->with('message', 'Your post has been created');
    }

    public function show()
    {
        $post = Post::where('id', request()->id)->firstOrFail();
        return view('post', compact('post'));
    }

    public function destroy()
    {
        //
    }

    protected function validatePost()
    {
        return request()->validate([
            'title' => 'required',
            'body' => 'required'
        ]);
    }
}
