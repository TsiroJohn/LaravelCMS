@extends('layouts.admin')

@section('content')
<div class="container">

        <div class="row">

            <h1 style="display: inline-block">Posts</h1>

            <a style="position:relative;bottom:8px;margin-left:10px" href="{{route('admin.posts.create')}}" class="btn btn-primary " role="button"> <i class="glyphicon glyphicon-plus fa-fw"></i>Create</a>
        </div>
        <div class="row">
            <table class='table'>
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Photo</th>                        
                        <th>User</th>
                        <th>Category</th>
                        <th>Title</th>
                        <th>Body</th>
                        <th>Created</th>
                        <th>Updated</th>

                    </tr>
                </thead>
                <tbody>
                    @if($posts)
                        @foreach($posts as $post)
                        <tr>
                        <td>{{$post->id}}</td>
                        <td><img height=50px src="{{ $post->photo ? $post->photo->file : 'http://placehold.it/150x150'}}" alt=""></td>
                        <td>{{$post->user->name}} </td>
                        <td>{{$post->category_id}}</td>
                        <td>{{$post->title}}</td>
                        <td>{{$post->body}}</td>
                        <td>{{$post->created_at->diffForHumans()}}</td>
                        <td>{{$post->updated_at->diffForHumans()}}</td>
                        <td><a  href="{{ route('admin.posts.edit',$post->id) }}" class="btn btn-info" role="button"><i class="glyphicon glyphicon-edit fa-fw"></i>Edit</a></td>
                        {!! Form::open(['id'=>'deleteButton','method'=>'DELETE','action'=>['AdminPostsController@destroy',$post->id],'onsubmit' => 'return ConfirmDelete()']) !!}
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



$('.remove').click(function(){


alert("eee");
swal({
title: "Are you sure want to remove this item?",
text: "You will not be able to recover this item",
type: "warning",
showCancelButton: true,
confirmButtonClass: "btn-danger",
confirmButtonText: "Confirm",
cancelButtonText: "Cancel",
closeOnConfirm: false,
closeOnCancel: false
},
function(isConfirm) {
if (isConfirm) {
 swal("Deleted!", "Your item deleted.", "success");
} else {
 swal("Cancelled", "You Cancelled", "error");
}
});
});

</script>