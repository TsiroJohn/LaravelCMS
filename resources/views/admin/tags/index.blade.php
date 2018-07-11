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
        #myTable td 
        {
            text-align: center; 
            vertical-align: middle;
        }
        .icon-button {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            outline: none;
            border: 0;
            background: transparent;
            color:#cc0000;
        }
        .icon-button-edit {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            outline: none;
            border: 0;
            background: transparent;
        }
        </style>
@stop
@section('content')

<h1 class="page-header">Tags</h1>



<div class="row">
    <div class="panel panel-default">
                <div class="panel-heading">
                    <ul>

                        <li><i class="fa fa-file-text-o"></i> All the current Tags</li>
                         <a style="" href="{{route('admin.tags.create')}}" class="" ><li> <i class="glyphicon glyphicon-plus fa-fw"></i>Add a tag</li></a>
                    </ul>
                </div>
                <div class="tags panel-body">
                    <table id="myTable"  class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Id</th>
                                <th>Name</th>                        
                                <th>Created</th>
                                <th>Updated</th>
                                <th></th>


                            </tr>
                        </thead>
                        <tbody>
                            @if($tags)
                                @foreach($tags as $tag)
                               
                                <tr class="item{{$tag->id}}">    
                                <td><a  href="{{ route('admin.tags.edit',$tag->id) }}" title="Edit" class="icon-button-edit" role="button"><i class="glyphicon glyphicon-edit fa-fw"></a></td>                            
                                <td>{{$tag->id}}</td>
                                <td>{{$tag->name}} </td>
                                <td>{{$tag->created_at ? $tag->created_at->diffForHumans() : 'No date'}}</td>
                                <td>{{$tag->updated_at ? $tag->updated_at->diffForHumans() : 'No date'}}</td>
                                <td>
                                
                                <button class="delete-button icon-button" title="Delete"  data-id="{{$tag->id}}" data-title="{{$tag->name}}">
                                                                <span class="glyphicon glyphicon-trash"></span></button>
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

$(document).ready(function() {
    $('#myTable').dataTable( {
            order: [],
            columnDefs: [ { orderable: false, targets: [0,-1] } ]
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
                                                    url : '/admin/tags/' + id,
                                                    type : "POST",
                                                    data : {'_method' : 'DELETE', '_token' : csrf_token},
                                                success : function(data) {
                                                    toastr.success('The tag has been succesfully deleted!', 'Success');
                                                    $(el).closest('tr').css('background','tomato');
                                                    $(el).closest('tr').fadeOut(800, function(){ 
                                                    $(this).remove();
                                                    });
                                                    //   $('.item' + id).remove();
                                                 },
                                                error : function () {
                                                    toastr.error('The tag could not be deleted!', 'Error');    
                                                 }
                                            })
                                    }
                                }
                });

}); 

</script>
@stop