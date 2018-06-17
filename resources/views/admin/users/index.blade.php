@extends('layouts.admin')

@section('content')
<h1 class="page-header">Users</h1>
<div class="">
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
                  <td><img height="65px" width="65px" src="{{ $user->photo ? $user->photo->file : Auth::user()->gravatar }}" alt=""></td>
                  <td>{{$user->name}} </td>
                  <td>{{$user->email}}</td>
                  <td>{{$user->role->name}}</td>
                  <td>{{$user->is_active==1 ? 'Active':'No Active'}}</td>
                  <td>{{ $user->created_at  ? $user->created_at->diffForHumans() : 'No created date'}}</td>
                  <td>{{ $user->updated_at  ? $user->updated_at->diffForHumans() : 'No updated date'}}</td>
                  <td><a  href="{{ route('admin.users.edit',$user->id) }}" class="btn btn-warning" role="button"><i class="glyphicon glyphicon-edit fa-fw"></i>Edit</a></td>

                  {!! Form::open(['id'=>'','method'=>'DELETE','action'=>['AdminUsersController@destroy',$user->id],'onsubmit' => 'return ConfirmDelete()']) !!}
                  <td>{!! Form::button( '<i class="fa fa-trash fa-fw"></i><span>Delete</span>', ['type' => 'submit', 'class' => 'btn btn-danger remove'] ) !!}</td>
                  {!! Form::close() !!}
                  </tr>
                  @endforeach
              @endif
            </tbody>
        </table>

            <div class="row">
                <div class="col-md-6 col-md-offset-5">
                    {{ $users->render() }}
                </div>
            </div>
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
