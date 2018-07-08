@extends('layouts.admin')
@section('styles')
<style>
    .icon-button {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    outline: none;
    border: 0;
    background: transparent;
    color:#cc0000;
}
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
        #myTable td 
        {
            text-align: center; 
            vertical-align: middle;
        }
        .view-post {
            float: left;
            border-right:1px solid #bbb;
            display: block;
            padding: 14px 16px;
            text-align: center;
        }
        .view-replies {
            float: left;
            display: block;
            padding: 14px 16px;
            text-align: center;
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
            <table id="myTable" class="table table-striped table-bordered" style="width:100%">
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
                                <th></th>
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
                                            <a class="view-post" href="{{ route('home.post',$comment->post->slug) }}">View Post</a> 

                                            @if (count($comment->replies)>0)
                                            <a  class="view-replies @if (!count($comment->replies)>0) disabled @endif" href="{{ route('admin.comment.replies.show',$comment->id) }}">View Replies</a>                                        
                                            @endif

                                              
                               
                                    </td>  
                                    <td>  <button class="delete-button  icon-button" title="Delete"  data-id="{{$comment->id}}">
                                                <span class="glyphicon glyphicon-trash"></span>&nbsp;</button></td>
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


$(document).ready(function() {
   var table= $('#myTable').dataTable( {
            order: [],
            columnDefs: [ { orderable: false, targets: [0,-1,-2] } ]
            },ReturnCheckBox());


    function ReturnCheckBox(){
            $('input[type=checkbox]').iCheck({
                    handle: 'checkbox',
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue',
                    increaseArea: '20%'
                });          
            }


    table.on('draw.dt', function () {
        ReturnCheckBox()
           
    });        

  
});  



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




        $(document).ready(function(){
            $('input[type=checkbox]').on('ifChecked', function(event){
                
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
                            toastr.success('The comment has been approved!', 'Success');
                            // empty
                        },
                        error : function () {
                            toastr.error('The comment could not be approved!', 'Error');    
                        },
                    });
                });

            $('input[type=checkbox]').on('ifUnchecked', function(event){
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
                            toastr.warning('The comment has been unapproved!', 'Warning');
                            // empty
                        },
                        error : function () {
                            toastr.error('The comment could not be unapproved!', 'Error');    
                        },
                    });
                });
        });


</script>

@stop