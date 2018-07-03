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
<h1 class="page-header">Users</h1>

@if(Session::has('deleted_user'))
    <div   class="alert alert-danger alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('deleted_user') }}
    <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@elseif(Session::has('inserted_user'))
    <div id="success-alert" class="alert alert-success alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('inserted_user') }}
    <button type="button" class="close" data-dismiss="alert">x</button>
    </div>
@elseif(Session::has('updated_user'))
    <div  class="alert alert-success alert-dismissible fade in" data-auto-dismiss="2000" role="alert">{{ session('updated_user') }}
    <button type="button" class="close" data-dismiss="alert">x</button></div>
    </div>
@endif

      <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">
                        <ul>

                            <li><i class="fa fa-file-text-o"></i> All the current Users</li>
                            <a style="" href="{{route('admin.users.create')}}" class="" ><li> <i class="glyphicon glyphicon-plus fa-fw"></i>Add a User</li></a>
                        </ul>
                </div>
                <div class="users panel-body">
                        <table id="myTable" class='table table-hover'>
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                @if($users)
                                    @foreach($users as $user)
                                    <tr class="item{{$user->id}}">
                                    <td>{{$user->id}}</td>
                                    <td><img height="65px" width="65px" src="{{ $user->photo ? $user->photo->file : Auth::user()->gravatar }}" alt=""></td>
                                    <td>{{$user->name}} </td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role->name}}</td>
                                    <td>{{$user->is_active==1 ? 'Active':'No Active'}}</td>
                                    <td>{{ $user->created_at  ? $user->created_at->diffForHumans() : 'No created date'}}</td>
                                    <td>{{ $user->updated_at  ? $user->updated_at->diffForHumans() : 'No updated date'}}</td>
                                    <td><a  href="{{ route('admin.users.edit',$user->id) }}" class="btn btn-warning" role="button"><i class="glyphicon glyphicon-edit fa-fw"></i>Edit</a>
                                    @if($user->role->name<>'administrator')
                                    <button class="delete-button btn btn-danger"  data-id="{{$user->id}}" data-title="{{$user->name}}" data-content="{{$user->email}}">
                                                <span class="glyphicon glyphicon-trash"></span> Delete</button>
                                    @endif
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
        

        bootbox.confirm({message: "Are you sure you want to delete this user?",
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
                                                url : '/admin/users/' + id,
                                                type : "POST",
                                                data : {'_method' : 'DELETE', '_token' : csrf_token},
                                            success : function(data) {
                                                toastr.success('The user has been succesfully deleted!', 'Success');
                                                $(el).closest('tr').css('background','tomato');
                                                $(el).closest('tr').fadeOut(800, function(){ 
                                                $(this).remove();
                                                });
                                                
                                             },
                                            error : function () {
                                                toastr.error('The user could not be deleted!', 'Error');    
                                             }
                                        })
                                }
                            }
            });

}); 
  
</script>
@stop
