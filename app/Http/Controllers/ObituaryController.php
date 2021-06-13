<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class ObituaryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard. This page contains the list of posts
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $posts = Post::where('active_status', 1)->get();
        return view('obituary.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post
     * @return \illuminate\Http\Response
     */
    public function show(Post $post) {
        return view('obituary.show', [
            'post' => $post,
        ]);
    }
}
