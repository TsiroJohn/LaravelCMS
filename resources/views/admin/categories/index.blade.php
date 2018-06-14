@extends('layouts.admin')

@section('content')


<div class="">
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

    <h1 style="display: inline-block">Categories</h1>
    <a style="position:relative;bottom:8px;margin-left:10px" href="{{route('admin.categories.create')}}" class="btn btn-primary " role="button"> <i class="glyphicon glyphicon-plus fa-fw"></i>Create</a>
    
</div>
<div class="row">
    <table class='table'>
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>                        
                <th>Created</th>
                <th>Updated</th>

            </tr>
        </thead>
        <tbody>
            @if($categories)
                @foreach($categories as $category)
                <tr>
                <td>{{$category->id}}</td>
                <td>{{$category->name}} </td>
                <td>{{$category->created_at ? $category->created_at->diffForHumans() : 'No date'}}</td>
                <td>{{$category->updated_at ? $category->updated_at->diffForHumans() : 'No date'}}</td>
                <td><a  href="{{ route('admin.categories.edit',$category->id) }}" class="btn btn-warning pull-right" role="button"><i class="glyphicon glyphicon-edit fa-fw"></i>Edit</a></td>
                {!! Form::open(['id'=>'deleteButton','method'=>'DELETE','action'=>['AdminCategoriesController@destroy',$category->id],'onsubmit' => 'return ConfirmDelete()']) !!}
                <td>{!! Form::button( '<i class="fa fa-trash fa-fw"></i><span>Delete</span>', ['type' => 'submit', 'class' => 'btn btn-danger '] ) !!}</td>
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
var x = confirm("Are you sure you want to delete?");
if (x)
 return true;
else
 return false;
}
</script>