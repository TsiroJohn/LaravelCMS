<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\PostsCreateRequest;

use App\Post;
use Auth;
use App\Photo;
use App\User;
use App\Category;
use App\Comment;
use App\Tag;
use File;
use Session;
use Alert;
use View;
use Response;
use Redirect;
class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {


        // $posts = Post::paginate(5);
        $posts = Post::all();
        // if (request()->ajax()) {
        //     return Response::json(View::make('admin.posts.index', compact('posts'))->render());
        //     return view('posts', ['posts' => $posts])->render(); 
        // }
        return view('admin.posts.index', compact('posts'));

        // return view('admin.posts.index',compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories=Category::pluck('name','id')->all();
        $tags=Tag::pluck('name','id')->all();
        
        return view('admin.posts.create',compact('categories','tags'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostsCreateRequest $request)
    {
        // dd($request);
        $input = $request->all();
         $user = Auth::user();

        if($file = $request->file('photo_id')){
          $name= time().$file->getClientOriginalName();
          $file->move('images', $name);
          $photo = Photo::create(['file'=>$name]);
          $input['photo_id']= $photo-> id;
        }

        $post= $user->posts()->create($input);
        $post->tags()->sync($request->tags,false);
        // Session::flash('inserted_post','A new post has been created!');

        $notification = array(
            'message' => 'A new post has been created!', 
            'alert-type' => 'success'
        );
          return Redirect::to('admin/posts')->with($notification);

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
    public function edit($id)
    {
        $post=Post::findOrFail($id);
        $categories=Category::pluck('name','id')->all();
        $tags=Tag::pluck('name','id')->all();

        return view('admin.posts.edit',compact('post','categories','tags'));
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
        // dd($request);
        $input = $request->all();
        if($file = $request->file('photo_id')){
            $name= time().$file->getClientOriginalName();
            $file->move('images', $name);
            $photo = Photo::create(['file'=>$name]);
            $input['photo_id']= $photo-> id;
          }

        //   Auth::user()->posts()->whereId($id)->first()->update($input);
          $post = Post::findOrFail($id);
          $post->update($input);
        //   $tags = $request->input('tag', []);
          $post->tags()->sync($request->tags, true);


          $notification = array(
            'message' => 'The post has been succesfully updated', 
            'alert-type' => 'success'
            );
          return Redirect::to('admin/posts')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post= Post::findOrFail($id)->delete();
        If(isset($post->photo->file)){
        if(File::exists(public_path(). isset($post->photo->file))){
            File::delete(public_path(). $post->photo->file);
          }}
        

        //   Session::flash('deleted_post','The post has been deleted!');
        return  response()->json($post);
        
        
    }

    

   
}
