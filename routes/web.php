<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/','HomeController@index' );
Route::auth();

Route::get('/home', 'HomeController@index');

// Route::resource('admin/users','AdminUsersController');

Route::get('/post/{id}',['as'=>'home.post','uses'=>'HomeController@post']);
Route::get('/category/{category}',['as'=>'category','uses'=>'HomeController@category']);
Route::get('/tag/{tag}',['as'=>'tag','uses'=>'HomeController@tag']);



Route::group(['middleware'=>'admin'],function(){

    Route::resource('admin/users','AdminUsersController',['names'=>[
        'index'=>'admin.users.index',
        'create'=>'admin.users.create',
        'store'=>'admin.users.store',
        'edit'=>'admin.users.edit',
    ]]);
    Route::resource('admin/posts','AdminPostsController',['names'=>[
        'index'=>'admin.posts.index',
        'create'=>'admin.posts.create',
        'store'=>'admin.posts.store',
        'edit'=>'admin.posts.edit',
    ]]);

    Route::resource('admin/categories','AdminCategoriesController',['names'=>[
        'index'=>'admin.categories.index',
        'create'=>'admin.categories.create',
        'store'=>'admin.categories.store',
        'edit'=>'admin.categories.edit',
    ]]);
    Route::resource('admin/tags','AdminTagController',['names'=>[
        'index'=>'admin.tags.index',
        'create'=>'admin.tags.create',
        'store'=>'admin.tags.store',
        'edit'=>'admin.tags.edit',
    ]]);
    Route::resource('admin/media','AdminMediaController',['names'=>[
        'index'=>'admin.media.index',
        'create'=>'admin.media.create',
        'store'=>'admin.media.store',
        'edit'=>'admin.media.edit',
    ]]);

    Route::resource('admin/comments','PostCommentsController',['names'=>[
        'index'=>'admin.comments.index',
        'create'=>'admin.comments.create',
        'store'=>'admin.comments.store',
        'edit'=>'admin.comments.edit',
        'show'=>'admin.comments.show',
    ]]);

    Route::post('admin/comments/changeStatus', array('as' => 'changeStatus', 'uses' => 'PostCommentsController@changeStatus'));
    
    Route::resource('admin/comment/replies','CommentRepliesController',['names'=>[
        'index'=>'admin.comment.replies.index',
        'show'=>'admin.comment.replies.show',
    ]]);
    Route::post('admin/comment/replies/changeReplyStatus', array('as' => 'changeReplyStatus', 'uses' => 'CommentRepliesController@changeReplyStatus'));

 //Για να σε κανει redirect στην αρχική αν δεν έχεις Admin Role
 Route::get('/admin','AdminController@index');
});


   

Route::group(['middleware'=>'auth'],function(){

    Route::post('comment/reply','CommentRepliesController@createReply');

    Route::post('admin/comments','PostCommentsController@store');
    


});

