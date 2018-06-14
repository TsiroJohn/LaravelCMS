@extends('layouts.admin')

@section('content')
<div class="">

    @if(Session::has('deleted_photo'))
    <div   class="alert alert-danger alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('deleted_photo') }}
        <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@elseif(Session::has('inserted_post'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('inserted_post') }}
        <button type="button" class="close" data-dismiss="alert">x</button>
    </div>
@elseif(Session::has('updated_post'))
    <div  class="alert alert-success alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('updated_post') }}
        <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@endif
            <div class="row">

                <h1 style="display: inline-block">Media</h1>

                <a style="position:relative;bottom:8px;margin-left:10px" href="{{route('admin.media.create')}}" class="btn btn-primary " role="button"> <i class="glyphicon glyphicon-plus fa-fw"></i>Upload</a>

            </div>     
            <div class="row">
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Id</th>                       
                                        <th>Photo</th>                        
                                        <th>Created</th>
                                        <th>Updated</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @if($photos)
                                        @foreach($photos as $photo)
                                        <tr>
                                        <td>{{$photo->id}}</td>          
                                        <td><img height="65px" width="65px" src="{{ $photo->file ? $photo->file : 'http://placehold.it/150x150'}}" alt=""></td>
                                        <td>{{$photo->created_at ? $photo->created_at->diffForHumans() : 'No date'}}</td>
                                        <td>{{$photo->updated_at->diffForHumans()}}</td>
                                        {!! Form::open(['id'=>'deleteButton','method'=>'DELETE','action'=>['AdminMediaController@destroy',$photo->id],'onsubmit' => 'return ConfirmDelete()']) !!}
                        <td>{!! Form::button( '<i class="fa fa-trash fa-fw"></i><span>Delete</span>', ['type' => 'submit', 'class' => 'btn btn-danger'] ) !!}</td>
                                         {!! Form::close() !!}
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
            </div>
           
</div>

@stop

<script type="text/javascript">


function ConfirmDelete()
{
var x = confirm("Are you sure you want to delete?");
if (x)
return true;
else
return false;
}
</script>
