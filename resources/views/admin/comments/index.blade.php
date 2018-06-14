@extends('layouts.admin')

@section('content')
<div class="">

@if(Session::has('comment_approved'))
    <div   class="alert alert-info alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('comment_approved') }}
    <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@elseif(Session::has('comment_unapproved'))
    <div  class="alert alert-info alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('comment_unapproved') }}
    <button type="button" class="close" data-dismiss="alert">x</button>
    </div>
@elseif(Session::has('comment_deleted'))
    <div  class="alert alert-danger alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('comment_deleted') }}
    <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@endif
         <div class="row">

             <h1 style="display: inline-block">Comments</h1>
         </div>
                <div class="row">
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User</th>                                                        
                                <th>Post</th>                                             
                                <th>Comment</th>                      
                                <th>Approve</th>                      
                                <th>Created</th>
                                <th>Updated</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if($comments)
                                @foreach($comments as $comment)
                                <tr>
                                <td>{{$comment->id}}</td>
                                <td>{{$comment->user->name}} </td>                                
                                <td>{{$comment->post->title}} </td>
                                <td>{{ str_limit($comment->body,20) }}</td>
                                <td>{{$comment->is_active==1 ? 'Approved':'Not Approved'}} </td>                                
                                <td>{{$comment->created_at ? $comment->created_at->diffForHumans() : 'No date'}}</td>
                                <td>{{$comment->updated_at ? $comment->updated_at->diffForHumans() : 'No date'}}</td>
                                <td><a class="btn btn-primary" href="{{ route('home.post',$comment->post->id) }}"><i class="fa fa-eye fa-fw"></i>View Post</a> </td>
                                @if (count($comment->replies)>0)
                                <td><a class="btn btn-success" href="{{ route('admin.comment.replies.show',$comment->id) }}"><i class="fa fa-eye fa-fw"></i>View Replies</a> </td>                                             
                                @else
                                <td><a disabled class="btn btn-success" href="{{ route('admin.comment.replies.show',$comment->id) }}"><i class="fa fa-eye fa-fw"></i>View Replies</a> </td>                                              
                                @endif
                                    @if($comment->is_active == 1)
                                                        
                                        {!! Form::open(['method'=>'PATCH','action'=>['PostCommentsController@update',$comment->id]]) !!}

                                        <input type="hidden" name="is_active" value="0">
                                        <div class="form-group">
                                             <td>{!! Form::button( '<i class="fa fa-times fa-fw"></i><span>Un-Approve</span>', ['type' => 'submit', 'class' => 'btn btn-danger'] ) !!}</td>
                                        </div>

                                        {!! Form::close() !!}
                                    @else

                                        {!! Form::open(['method'=>'PATCH','action'=>['PostCommentsController@update',$comment->id]]) !!}

                                        <input type="hidden" name="is_active" value="1">
                                        <div class="form-group">
                                         <td>{!! Form::button( '<i class="fa fa-check fa-fw"></i><span>Approve</span>', ['type' => 'submit', 'class' => 'btn btn-success'] ) !!}</td>
                                        </div>

                                        {!! Form::close() !!}
                                    @endif

                              
                                <td>
                                        {!! Form::open(['id'=>'','method'=>'DELETE','action'=>['PostCommentsController@destroy',$comment->id],'onsubmit' => 'return ConfirmDelete()']) !!}
                                        {!! Form::button( '<i class="fa fa-trash fa-fw"></i><span>Delete</span>', ['type' => 'submit', 'class' => 'btn btn-danger remove'] ) !!}
                                        {!! Form::close() !!}
                                        </td>
                              
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
var x =  confirm("Are you sure want to remove this comment?");

if (x)
 return true;
else
 return false;
}
</script>