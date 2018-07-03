<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Comment;
use App\User;

class AdminController extends Controller
{
    //
    public function index(){

        $postCount = Post::count();
        $userCount = User::where('role_id', '<>', 1)->count();
        $categoriesCount = Category::count();
        $commentsCount = Comment::count();
        $unapprovedComments = Comment::where('is_active', '=', 0)->count();
        $posts = Post::orderBy('id', 'desc')->take(5)->get();
        return view('admin/index',compact('postCount','categoriesCount','commentsCount','userCount','unapprovedComments','posts'));
    }
}
