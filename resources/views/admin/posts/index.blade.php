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
<h1 class="page-header">Posts</h1>

@if(Session::has('deleted_post'))
    <div   class="alert alert-danger alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('deleted_post') }}
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
            
            <div class="panel panel-default">
                <div class="panel-heading">
                    <ul>

                        <li><i class="fa fa-file-text-o"></i> All the current Posts</li>
                         <a style="" href="{{route('admin.posts.create')}}" class="" ><li> <i class="glyphicon glyphicon-plus fa-fw"></i>Add a Post</li></a>
                    </ul>
                </div>
                <div class="posts panel-body">
                    <table id="myTable" class='table  table-hover'>
                        <thead>
                            <tr>
                             
                                <th>Id</th>
                                <th>Photo</th>   
                                <th>Title</th>
                                <th>User</th>
                                <th>Category</th>
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>

                            </tr>
                        </thead>
                        <tbody>
                            @if($posts)
                                @foreach($posts as $post)
                                <tr class="item{{$post->id}}">
                                  
                                <td>{{$post->id}}</td>
                                <td><img height="65px" width="65px" src="{{ $post->photo ? $post->photo->file : 'http://placehold.it/150x150'}}" alt=""></td>
                                <td>{{ str_limit($post->title,30)}}</td>
                                <td>{{$post->user->name}} </td>
                                <td>{{$post->category ? $post->category->name : 'No category'}}</td>
                                <td>{{$post->created_at->diffForHumans()}}</td>
                                <td>{{$post->updated_at->diffForHumans()}}</td>
                                <td>
                                <a class="btn btn-success" href="{{ route('home.post',$post->slug) }}"><i class="fa fa-eye fa-fw"></i> View</a>
                                <a  class="btn btn-primary @if (!count($post->comments)>0) disabled @endif"  href="{{ route('admin.comments.show',$post->id) }}"><i class="fa fa-eye fa-fw"></i> Comments</a> <a  href="{{ route('admin.posts.edit',$post->id) }}" class="btn btn-warning" role="button"><i class="glyphicon glyphicon-edit fa-fw"></i> Edit</a>
                                <button class="delete-button btn btn-danger"  data-id="{{$post->id}}" data-title="{{$post->title}}" data-content="{{$post->body}}">
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
                                                    url : '/admin/posts/' + id,
                                                    type : "POST",
                                                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                                                success : function(data) {
                                                    toastr.success('The post has been succesfully deleted!', 'Success');
                                                    $(el).closest('tr').css('background','tomato');
                                                    $(el).closest('tr').fadeOut(800, function(){ 
                                                    $(this).remove();
                                                    });
                                                    //   $('.item' + id).remove();
                                                 },
                                                error : function () {
                                                    toastr.error('The post could not be deleted!', 'Error');    
                                                 }
                                            })
                                    }
                                }
                });

}); 


    // $(window).on('hashchange', function() {
    //     if (window.location.hash) {
    //         var page = window.location.hash.replace('#', '');
    //         if (page == Number.NaN || page <= 0) {
    //             return false;
    //         } else {
    //             getPosts(page);
    //         }
    //     }
    // });
    // $(document).ready(function() {
    //     $(document).on('click', '.pagination a', function (e) {
    //         getPosts($(this).attr('href').split('page=')[1]);
    //         e.preventDefault();
    //     });
    // });
    // function getPosts(page) {
    //     $.ajax({
    //         url : '?page=' + page,
    //         dataType: 'json',
    //     }).done(function (data) {
    //         $('.posts').html(data);
    //         location.hash = page;
    //     }).fail(function () {
    //         alert('Posts could not be loaded.');
    //     });
    // }
</script>




@stop