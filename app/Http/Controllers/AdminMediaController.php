<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Photo;
use Session;

class AdminMediaController extends Controller
{
    //

    public function index()
    {
        $photos= Photo::all();

        return view('admin.media.index',compact('photos'));
    }

    public function create()
    {
        return view('admin.media.create');

    }

    public function store(Request $request)
    {
        $file = $request->file('file');
        $name = time().$file->getClientOriginalName();

        $file ->move('images',$name);

        Photo::create(['file'=>$name]);
        
    }

    public function destroy($id){



        $photo= Photo::findOrFail($id)->delete();
        If(isset($photo->file)){
        if(File::exists(public_path(). isset($photo->file))){
            File::delete(public_path(). $photo->file);
          }}
          Session::flash('deleted_photo','The photo has been deleted!');
        
        return redirect('/admin/media');


    }

 
}
