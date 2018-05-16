@extends('layouts.admin')

@section('content')

@if(Session::has('deleted_user'))
    <div  class="p-3 mb-2 bg-danger text-white">{{ session('deleted_user') }}</div>
@elseif(Session::has('inserted_user'))
    <div  class="p-3 mb-2 bg-success text-white">{{ session('inserted_user') }}</div>
@elseif(Session::has('updated_user'))
    <div  class="p-3 mb-2 bg-success text-white">{{ session('updated_user') }}</div>
@endif

<h1>Users</h1>

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
        <td><a href="{{route('admin.users.edit', $user->id)}}" class="btn btn-info" role="button">Edit</a></td>
        <td><button class="btn btn-danger"> Delete</button></td>
        </tr>
        @endforeach
     @endif
    </tbody>
</table>

@stop