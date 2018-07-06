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
        .iradio_flat-blue {
            background: url(https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/flat/blue.png) no-repeat;
        }
        .iradio_flat-yellow {
            background: url(https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/yellow.png) no-repeat;
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
                                <th>Approved</th>                                                        
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
                                     <td class="text-center"><input type="checkbox" class="published" data-id="{{$comment->id}}" @if ($comment->is_active) checked @endif></td>
                                     <td>{{$comment->created_at ? $comment->created_at->diffForHumans() : 'No date'}}</td>
                                     <td>{{$comment->updated_at ? $comment->updated_at->diffForHumans() : 'No date'}}</td>
                                     <td>
                                            <a class="btn btn-primary" href="{{ route('home.post',$comment->post->slug) }}"><i class="fa fa-eye fa-fw"></i>Post</a> 
                                            <a  class="btn btn-success @if (!count($comment->replies)>0) disabled @endif" href="{{ route('admin.comment.replies.show',$comment->id) }}"><i class="fa fa-eye fa-fw"></i>Replies</a>                                        
                                        

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
<script>
  $(window).load(function(){
            $('#myTable').removeAttr('style');
        })

        $(document).ready(function(){
            $('.published').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue',
                increaseArea: '20%'
            });
            $('.published').on('ifClicked', function(event){
                id = $(this).data('id');
                $.ajax({
                    headers: {
                             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                    type: 'POST',
                    url: "{{ URL::route('changeStatus') }}",
                    data: {
                        '_token': $('input[name=_token]').val(),
                        'id': id
                    },
                    success: function(data) {
                        toastr.success('The comment has been succesfully approved!', 'Success');
                        // empty
                    },
                    error : function () {
                        toastr.error('The comment could not be approved!', 'Error');    
                    },
                });
            });
          
        });

    </script>

<script type="text/javascript">

    $(document).ready( function () {
    $('#myTable').DataTable();
    } );

$(document).on('click', '.delete-button', function (e) {

e.preventDefault();
var id = $(this).data('id');
var el = this;

        var csrf_token = $('meta[name="csrf-token"]').attr('content');
  
        bootbox.confirm({message: "Are you sure you want to delete this post?",
                            title: "Warning",
                            buttons: {
                                confirm: {
                                    label: 'Yes',
                                    className: 'btn-success'
                                },
                                cancel: {
                                    label: 'No',
                                    className: 'btn-danger'
                                }
                            },
                            callback: function (result) {
                                if(result){ 
                                        $.ajax({
                                                url : '/admin/comments/' + id,
                                                type : "POST",
                                                data : {'_method' : 'DELETE', '_token' : csrf_token},
                                            success : function(data) {
                                                toastr.success('The comment has been succesfully deleted!', 'Success');
                                                $(el).closest('tr').css('background','tomato');
                                                $(el).closest('tr').fadeOut(800, function(){ 
                                                // $(this).remove();

                                                });
                                                //   $('.item' + id).remove();
                                             },
                                            error : function () {
                                                toastr.error('The comment could not be deleted!', 'Error');    
                                             }
                                        })
                                }
                            }
            });

}); 

</script>

@stop