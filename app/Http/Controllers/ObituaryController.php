<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
use Validator;
use App\Post;
use App\Comment;

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

    /**
     * Display the specified resource. Using the Vue rendering.
     *
     * @param \App\Post
     * @return \illuminate\Http\Response
     */
    public function showVue(Post $post) {
        return $post->approvedComments;
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Post
     * @return \illuminate\Http\Response
     */
    public function saveCondolence(Request $request) {

        $rules = array(
            'post_id' => 'required|integer',
            'message' => 'required|string|max:150',
            'fullname' => 'string',
            'relationship' => 'required|string|max:100',
            'email' => 'email',
            'address' => 'string'
        );

        $Comment=new Comment;
        if($Comment->rules){
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return false;
            }
        }
        
        if (\Auth::user()) {
            $commenter_id = \Auth::user()->id;
            $commenter_type = "App\User";
        }else{
            $commenter_id = null;
            $commenter_type = null;
        }

        $Comment->commenter_id = $commenter_id;
        $Comment->commenter_type = $commenter_type;
        $Comment->guest_name = $request->fullname;
        $Comment->guest_email = $request->email;
        $Comment->commentable_type = "App\Post";
        $Comment->commentable_id = $request->post_id;
        $Comment->comment = $request->message;
        $Comment->approved = true;
        $Comment->save();

        return ['resp_code'=>'000', 'resp_desc' => ' Condolence added succesfully'];
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post
     * @return \illuminate\Http\Response
     */
    public function deleteCondolence(Request $request) {

        $rules = array(
            'comment_id' => 'required|integer',
        );

        $Comment=new Comment;
        if($Comment->rules){
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return false;
            }
        }

        $comment = Comment::find($request->comment_id);
        $comment->approved = false;
        $comment->save();

        return ['resp_code'=>'000', 'resp_desc' => ' Condolence has been deleted succesfully'];
    }

}
