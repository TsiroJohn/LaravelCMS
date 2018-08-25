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
                        ->get();
                        } else {
                        $posts = Post::latest()->get();
                        }
        // if ($month = request('month')){
        //     $posts->whereMonth('created_at',Carbon::parse($month)->month);
        // }

        // if($year =request('year')){
        //     $posts->whereYear('created_at',$year);
        // }

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
