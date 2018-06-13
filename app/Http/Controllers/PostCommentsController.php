<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\CommentRequest;
use App\Comment;
use App\Post;
use Auth;
use Session;


class PostCommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $comments = Comment::all();
        return view('admin.comments.index',compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CommentRequest $request)
    {
        $user = Auth::user();
        $data = [
            'post_id' => $request->post_id,
            'user_id'=> $user->id,
            'body' => $request->body
        ];
        Comment::create($data);

        $request->session()->flash('comment_message','Your message has been submitted and is waiting approval');

        return redirect()->back();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);

        $comments = $post->comments;

        return view('admin.comments.show',compact('comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        Comment::findOrFail($id)->update($request->all());
        if ($request->is_active==1)
        {
            $request->session()->flash('comment_approved','The comment has been approved!');
        }
        else
        {
            $request->session()->flash('comment_unapproved','The comment has been un-approved!');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Comment::findOrFail($id)->delete();
    

          Session::flash('comment_deleted','The comment has been deleted!');
          return redirect()->back();

    }
}
