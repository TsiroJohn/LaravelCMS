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

<h1 class="page-header">Categories</h1>

@if(Session::has('deleted_category'))
    <div   class="alert alert-danger alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('deleted_category') }}
    <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@elseif(Session::has('inserted_category'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('inserted_category') }}
    <button type="button" class="close" data-dismiss="alert">x</button>
    </div>
@elseif(Session::has('updated_categories'))
    <div  class="alert alert-success alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('updated_categories') }}
    <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@endif

<div class="row">
    <div class="panel panel-default">
                <div class="panel-heading">
                    <ul>

                        <li><i class="fa fa-file-text-o"></i> All the current Categories</li>
                         <a style="" href="{{route('admin.categories.create')}}" class="" ><li> <i class="glyphicon glyphicon-plus fa-fw"></i>Add a Category</li></a>
                    </ul>
                </div>
                <div class="categories panel-body">
                    <table id="myTable" class='table table-hover'>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>                        
                                <th>Created</th>
                                <th>Updated</th>
                                <th>Actions</th>


                            </tr>
                        </thead>
                        <tbody>
                            @if($categories)
                                @foreach($categories as $category)
                                <tr class="item{{$category->id}}">                                
                                <td>{{$category->id}}</td>
                                <td>{{$category->name}} </td>
                                <td>{{$category->created_at ? $category->created_at->diffForHumans() : 'No date'}}</td>
                                <td>{{$category->updated_at ? $category->updated_at->diffForHumans() : 'No date'}}</td>
                                <td><a  href="{{ route('admin.categories.edit',$category->id) }}" class="btn btn-warning" role="button"><i class="glyphicon glyphicon-edit fa-fw"></i>Edit</a>
                                
                                <button class="delete-button btn btn-danger"  data-id="{{$category->id}}" data-title="{{$category->name}}">
                                                                <span class="glyphicon glyphicon-trash"></span> Delete</button>
                                </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
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
                                                    url : '/admin/categories/' + id,
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

</script>
@stop