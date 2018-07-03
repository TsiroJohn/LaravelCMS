<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests;
use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersEditRequest;
use App\User;
use App\Role;
use App\Photo;
use File;
use Session;
use Alert;
use Response;
use Redirect;
class AdminUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users= User::all();
        return view('admin.users.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles=Role::pluck('name','id')->all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {

        if($request->password ==''){
            $input= $request->except('password');
        }else{
            $input = $request->all();
            $input['password']=bcrypt($request->password);
        }

        if($file=$request->file('photo_id'))
        {
            $name = time() . $file->getClientOriginalName();

            $file->move('images',$name);

            $photo = Photo::create(['file'=>$name]);

             $input['photo_id']=$photo->id;
            
        }   


        User::create($input);    

          $notification = array(
            'message' => 'A new post has been created!', 
            'alert-type' => 'success'
        );
          return Redirect::to('admin/users')->with($notification);
        
        
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
        return view('admin.users.show');
        
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
        $user=User::findOrFail($id);
        $roles = Role::pluck('name','id')->all();
        return view('admin.users.edit',compact('user','roles'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersEditRequest $request, $id)
    {
        //
        $user= User::findOrFail($id);
        if($request->password ==''){
            $input= $request->except('password');
        }
        else
        {
            $input = $request->all();
            $input['password']=bcrypt($request->password);
        }


        if($file=$request->file('photo_id'))
        {
            $name =time().$file->getClientOriginalName();

            $file->move('images',$name);
            $photo=Photo::create(['file'=>$name]);
            $input['photo_id'] = $photo->id;
        }

     

        $user->update($input);
        
        $notification = array(
            'message' => 'The user has been succesfully updated', 
            'alert-type' => 'success'
        );
          return Redirect::to('admin/users')->with($notification);
        

        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user= User::findOrFail($id);
        If(isset($user->photo->file)){
        if(File::exists(public_path(). isset($user->photo->file))){
            File::delete(public_path(). $user->photo->file);
          }}
        
        // unlink(public_path(). $user->photo->file);
        $user->delete();
        // Session::flash('deleted_user','The user has been deleted!');

        return  response()->json($user);
    }

    
}
