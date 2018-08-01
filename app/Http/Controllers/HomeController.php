<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Post;
use App\Tag;
use App\Category;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $posts = Post::paginate(5);
        $categories = Category::all();
        $tags = Tag::all();


        return view('front/home',compact('posts','categories','tags'));
    }

    public function post($slug){
        $post = Post::findBySlugOrFail($slug);
        $tags = Tag::all();

        $categories=Category::all();
        
        $comments = $post->comments()->whereIsActive(1)->get();
        return view('post',compact('post','categories','comments','tags'));

    }
}
