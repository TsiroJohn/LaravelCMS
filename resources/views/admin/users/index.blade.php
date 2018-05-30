@extends('layouts.admin')

@section('content')
<div class="container">
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

      <h1 style="display: inline-block">Users</h1>

      <a style="position:relative;bottom:8px;margin-left:10px" href="{{route('admin.users.create')}}" class="btn btn-primary " role="button"> <i class="glyphicon glyphicon-plus fa-fw"></i>Create</a>
      </div>
      <div class="row">

        <table class='table'>
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

              </tr>
            </thead>
            <tbody>
              @if($users)
                  @foreach($users as $user)
                  <tr>
                  <td>{{$user->id}}</td>
                  <td><img height=50px src="{{ $user->photo ? $user->photo->file : 'http://placehold.it/150x150'}}" alt=""></td>
                  <td>{{$user->name}} </td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->role->name}}</td>
                  <td>{{$user->is_active==1 ? 'Active':'No Active'}}</td>
                  <td>{{$user->created_at->diffForHumans()}}</td>
                  <td>{{$user->updated_at->diffForHumans()}}</td>
                  <td><a  href="{{ route('admin.users.edit',$user->id) }}" class="btn btn-info" role="button"><i class="glyphicon glyphicon-edit fa-fw"></i>Edit</a></td>

                  {!! Form::open(['id'=>'','method'=>'DELETE','action'=>['AdminUsersController@destroy',$user->id],'onsubmit' => 'return ConfirmDelete()']) !!}
                  <td>{!! Form::button( '<i class="fa fa-trash fa-fw"></i><span>Delete</span>', ['type' => 'submit', 'class' => 'btn btn-danger remove'] ) !!}</td>
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
  var x =  confirm("Are you sure want to remove this user?");

  if (x)
    return true;
  else
    return false;
  }


  


// $('.remove').click(function(){


// alert("eee");
// swal({
//   title: "Are you sure want to remove this item?",
//   text: "You will not be able to recover this item",
//   type: "warning",
//   showCancelButton: true,
//   confirmButtonClass: "btn-danger",
//   confirmButtonText: "Confirm",
//   cancelButtonText: "Cancel",
//   closeOnConfirm: false,
//   closeOnCancel: false
// },
// function(isConfirm) {
//   if (isConfirm) {
//     swal("Deleted!", "Your item deleted.", "success");
//   } else {
//     swal("Cancelled", "You Cancelled", "error");
//   }
// });
// });
  
</script>
