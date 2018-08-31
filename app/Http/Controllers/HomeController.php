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
        //Αφαιρέθηκε ώστε να μπο΄ρεί κάποιος να βλέπει το site, χώρις απαραίτητα να ειναι μέλος
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        

                    if (request(['month', 'year'])) {
                        $posts = Post::latest()
                        ->filter(request(['month', 'year']))
                        ->paginate(5);
                        } else {
                        $posts = Post::orderBy('created_at','desc')
                        ->paginate(5);
                        }

        $categories = Category::all();
        $tags = Tag::all();
        $archives = Post::selectRaw('year(created_at) year,monthname(created_at) month, count(*) published')
                    ->groupBy('year','month')
                    ->orderByRaw('min(created_at) desc')
                    ->get()
                    ->toArray();

        return view('front/home',compact('posts','categories','tags','archives'));
    }

    public function category($id)
    {
        
        $posts = Post::where('category_id',$id)
        ->orderBy('created_at','desc')
        ->paginate(5);

        $categories = Category::all();
        $tags = Tag::all();
        $archives = Post::selectRaw('year(created_at) year,monthname(created_at) month, count(*) published')
                    ->groupBy('year','month')
                    ->orderByRaw('min(created_at) desc')
                    ->get()
                    ->toArray();

        return view('front/home',compact('posts','categories','tags','archives'));
    }

    public function tag($id)
    {
        
        $posts=Tag::findOrFail($id)->posts;
    //     $tagName=$tag->name;
    //     Post::whereHas('tags', function($q) use($tagName) {
    //     $q->whereIn('name', $tagName);
    // })
        // $posts = Post::with('tags')->whereDoesntHave('tags', function ($q) {
        //     $q->where('tag'.'id', '=', 2);})
        // ->orderBy('created_at','desc')
        // 
      

        $categories = Category::all();
        $tags = Tag::all();
        $archives = Post::selectRaw('year(created_at) year,monthname(created_at) month, count(*) published')
                    ->groupBy('year','month')
                    ->orderByRaw('min(created_at) desc')
                    ->get()
                    ->toArray();

        return view('front/home',compact('posts','categories','tags','archives'));
    }

    public function post($slug){
        $post = Post::findBySlugOrFail($slug);
        $tags = Tag::all();

        $categories=Category::all();
        $archives = Post::selectRaw('year(created_at) year,monthname(created_at) month, count(*) published')
        ->groupBy('year','month')
        ->orderByRaw('min(created_at) desc')
        ->get()
        ->toArray();

        $comments = $post->comments()->whereIsActive(1)->get();
        return view('post',compact('post','categories','comments','tags','archives'));

    }
}
