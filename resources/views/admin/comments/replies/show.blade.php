@extends('layouts.admin')

@section('content')
<div class="">

@if(Session::has('reply_approved'))
    <div   class="alert alert-info alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('reply_approved') }}
    <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@elseif(Session::has('reply_unapproved'))
    <div  class="alert alert-info alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('reply_unapproved') }}
    <button type="button" class="close" data-dismiss="alert">x</button>
    </div>
@elseif(Session::has('reply_deleted'))
    <div  class="alert alert-danger alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('reply_deleted') }}
    <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@endif
         <div class="row">

             <h1 style="display: inline-block">Replies</h1>
         </div>
                <div class="row">
                    <table class='table'>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User</th>                                                        
                                <th>Post</th>                                             
                                <th>Reply</th>                      
                                <th>Approve</th>                      
                                <th>Created</th>
                                <th>Updated</th>
                                <th></th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if($replies)
                                @foreach($replies as $reply)
                                <tr>
                                <td>{{$reply->id}}</td>
                                <td>{{$reply->user->name}} </td>                                
                                <td>{{$reply->comment->post->title}} </td>
                                <td>{{ str_limit($reply->body,20) }}</td>
                                <td>{{$reply->is_active==1 ? 'Approved':'Not Approved'}} </td>                                
                                <td>{{$reply->created_at ? $reply->created_at->diffForHumans() : 'No date'}}</td>
                                <td>{{$reply->updated_at ? $reply->updated_at->diffForHumans() : 'No date'}}</td>
                                <td><a class="btn btn-primary" href="{{ route('home.post',$reply->comment->post->id) }}"><i class="fa fa-eye fa-fw"></i>View Post</a> </td>

                                    @if($reply->is_active == 1)
                                                        
                                        {!! Form::open(['method'=>'PATCH','action'=>['CommentRepliesController@update',$reply->id]]) !!}

                                        <input type="hidden" name="is_active" value="0">
                                        <div class="form-group">
                                             <td>{!! Form::button( '<i class="fa fa-times fa-fw"></i><span>Un-Approve</span>', ['type' => 'submit', 'class' => 'btn btn-danger'] ) !!}</td>
                                        </div>

                                        {!! Form::close() !!}
                                    @else

                                        {!! Form::open(['method'=>'PATCH','action'=>['CommentRepliesController@update',$reply->id]]) !!}

                                        <input type="hidden" name="is_active" value="1">
                                        <div class="form-group">
                                         <td>{!! Form::button( '<i class="fa fa-check fa-fw"></i><span>Approve</span>', ['type' => 'submit', 'class' => 'btn btn-success'] ) !!}</td>
                                        </div>

                                        {!! Form::close() !!}
                                    @endif

                              
                                <td>
                                        {!! Form::open(['id'=>'','method'=>'DELETE','action'=>['CommentRepliesController@destroy',$reply->id],'onsubmit' => 'return ConfirmDelete()']) !!}
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