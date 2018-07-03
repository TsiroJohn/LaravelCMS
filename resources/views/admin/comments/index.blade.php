@extends('layouts.admin')
@section('styles')
<style>
        .panel-heading {
            padding: 0;
        }
        .panel-heading ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        .panel-heading li {
            float: left;
            border-right:1px solid #bbb;
            display: block;
            padding: 14px 16px;
            text-align: center;
        }
        .panel-heading li:last-child:hover {
            background-color: #ccc;
        }
        .panel-heading li:last-child {
            border-right: none;
        }
        .panel-heading li a:hover {
            text-decoration: none;
        }
        </style>
@stop
@section('content')
<h1 class="page-header">Comments</h1>

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
    <div class="panel panel-default">
        <div class="panel-heading">
                    <ul>
                        <li><i class="fa fa-file-text-o"></i> All the current Comments</li>                       
                    </ul>
        </div>
        <div class="comments panel-body">
            <table id="myTable" class='table table-hover'>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>User</th>                                                        
                                <th>Post</th>                                             
                                <th>Comment</th>                                                            
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($comments)
                                @foreach($comments as $comment)
                                <tr class="item{{$comment->id}}">
                                     <td>{{$comment->id}}</td>
                                     <td>{{$comment->user->name}} </td>                                
                                     <td>{{ str_limit($comment->post->title,20) }} </td>
                                     <td>{{ str_limit($comment->body,20) }}</td>
                                     <td>{{$comment->created_at ? $comment->created_at->diffForHumans() : 'No date'}}</td>
                                     <td>{{$comment->updated_at ? $comment->updated_at->diffForHumans() : 'No date'}}</td>
                                     <td>
                                            <a class="btn btn-primary" href="{{ route('home.post',$comment->post->slug) }}"><i class="fa fa-eye fa-fw"></i>Post</a> 
                                            <a  class="btn btn-success @if (!count($comment->replies)>0) disabled @endif" href="{{ route('admin.comment.replies.show',$comment->id) }}"><i class="fa fa-eye fa-fw"></i>Replies</a>                                        
                                            
                                            @if($comment->is_active == 1)
                                                 {!! Form::open(['method'=>'PATCH','action'=>['PostCommentsController@update',$comment->id]]) !!}
                                                    <input type="hidden" name="is_active" value="0">
                                                    <div class="form-group">
                                                        {!! Form::button( '<i class="fa fa-times fa-fw"></i><span>Un-Approve</span>', ['type' => 'submit', 'class' => 'btn btn-danger'] ) !!}
                                                    </div>
                                                 {!! Form::close() !!}
                                            @else
                                                 {!! Form::open(['method'=>'PATCH','action'=>['PostCommentsController@update',$comment->id]]) !!}

                                                    <input type="hidden" name="is_active" value="1">
                                                    <div class="form-group">
                                                    {!! Form::button( '<i class="fa fa-check fa-fw"></i><span>Approve</span>', ['type' => 'submit', 'class' => 'btn btn-success'] ) !!}
                                                    </div>
                                                {!! Form::close() !!}
                                            @endif

                                                <button class="delete-button btn btn-danger"  data-id="{{$comment->id}}">
                                                <span class="glyphicon glyphicon-trash"></span> Delete</button>
                               
                                    </td>  
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                </table>
        </div>
    </div>

    
</div>
@stop


@section('scripts')

<script type="text/javascript">

    $(document).ready( function () {
    $('#myTable').DataTable();
    } );


  function ConfirmDelete()
{
var x =  confirm("Are you sure want to remove this comment?");

if (x)
 return true;
else
 return false;
}
</script>

@stop